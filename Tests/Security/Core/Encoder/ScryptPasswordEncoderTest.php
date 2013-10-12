<?php
/*
 * Copyright (c) 2011-2013 Andrea Usuelli
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
namespace Usu\ScryptPasswordEncoderBundle\Tests\Security\Core\Encoder;

use Usu\ScryptPasswordEncoderBundle\Security\Core\Encoder\ScryptPasswordEncoder;
use Zend\Math\Rand;

class ScryptPasswordEncoderTest extends \PHPUnit_Framework_TestCase
{
    const PASSWORD = 'test_password';

    public function testPasswordValid()
    {
        $encoder = new ScryptPasswordEncoder(2048, 2, 1, 64);
        $salt = $this->generateSalt();
        $encodedPass = $encoder->encodePassword(self::PASSWORD, $salt);
        $this->assertTrue($encoder->isPasswordValid($encodedPass, self::PASSWORD, $salt));
        $this->assertFalse($encoder->isPasswordValid($encodedPass, 'wrong_password', $salt));
    }

    public function testIncreasedCost()
    {
        $time_start = microtime(true);

        $encoder = new ScryptPasswordEncoder(2048, 2, 1, 64);
        $encoder->encodePassword(self::PASSWORD, $this->generateSalt());

        $time_end = microtime(true);
        $time1 = $time_end - $time_start;

        $time_start = microtime(true);

        $encoder = new ScryptPasswordEncoder(4096, 4, 2, 64);
        $encoder->encodePassword(self::PASSWORD, $this->generateSalt());

        $time_end = microtime(true);
        $time2 = $time_end - $time_start;

        $this->assertGreaterThan($time1, $time2);
    }

    public function testPasswordLengthSuccess()
    {
        $encoder = new ScryptPasswordEncoder(2048, 2, 1, 64);
        $salt = $this->generateSalt();
        $password = $this->randomString(4096);
        $encodedPass = $encoder->encodePassword($password, $salt);

        $this->assertTrue($encoder->isPasswordValid($encodedPass, $password, $salt));
    }

    public function testPasswordLengthFailure()
    {
        $encoder = new ScryptPasswordEncoder(2048, 2, 1, 64);
        $salt = $this->generateSalt();
        $this->setExpectedException('Symfony\Component\Security\Core\Exception\BadCredentialsException');
        $encoder->encodePassword($this->randomString(4097), $salt);

        $this->assertFalse($encoder->isPasswordValid($this->randomString(96), $this->randomString(4097), $salt));
    }

    private function generateSalt()
    {
        return Rand::getBytes(64, true);
    }

    private function randomString($length = 64)
    {
        $string = '';
        $keys = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
        for($i = 0; $i < $length; $i++) {
            $string .= $keys[array_rand($keys)];

        }
        return $string;
    }
}
