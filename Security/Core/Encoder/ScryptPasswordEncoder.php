<?php
/*
 * Copyright (c) 2012-2013 Andrea Usuelli
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
namespace Usu\ScryptPasswordEncoderBundle\Security\Core\Encoder;

use Symfony\Component\Security\Core\Encoder\BasePasswordEncoder;
use Zend\Crypt\Key\Derivation\Scrypt;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

/**
 * @author Andrea Usuelli <andreausu@gmail.com>
 */
class ScryptPasswordEncoder extends BasePasswordEncoder
{
    /**
     * @var int
     */
    private $cpuCost;

    /**
     * @var int
     */
    private $memoryCost;

    /**
     * @var int
     */
    private $parallelizationCost;

    /**
     * @var int
     */
    private $keyLength;

    public function __construct($cpuCost, $memoryCost, $parallelizationCost, $keyLength)
    {
        $this->cpuCost = (int)$cpuCost;
        $this->memoryCost = (int)$memoryCost;
        $this->parallelizationCost = (int)$parallelizationCost;
        $this->keyLength = (int)$keyLength;
    }

    public function encodePassword($raw, $salt)
    {
        if ($this->isPasswordTooLong($raw)) {
            throw new BadCredentialsException('Invalid password.');
        }
        return base64_encode(Scrypt::calc($raw, $salt, $this->cpuCost, $this->memoryCost, $this->parallelizationCost, $this->keyLength));
    }

    public function isPasswordValid($encoded, $raw, $salt)
    {
        if ($this->isPasswordTooLong($raw)) {
            return false;
        }
        return ($encoded == $this->encodePassword($raw, $salt));
    }
}
