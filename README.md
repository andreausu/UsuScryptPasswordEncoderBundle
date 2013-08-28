UsuScryptPasswordEncoderBundle
==============================

This Bundle provides a Symfony2 password encoder service that uses [scrypt](http://en.wikipedia.org/wiki/Scrypt) for password encoding.

[![Build Status](https://travis-ci.org/andreausu/UsuScryptPasswordEncoderBundle.png?branch=master)](https://travis-ci.org/andreausu/UsuScryptPasswordEncoderBundle)


Why you should use scrypt
------------

The scrypt key derivation function is designed to be far more secure against hardware brute-force attacks than alternative functions such as PBKDF2 or bcrypt.

![KDF comparison](https://github.com/tarcieri/scrypt/raw/modern-readme/kdf-comparison.png)

The designers of scrypt estimate that on modern (2009) hardware, if 5 seconds are spent computing a derived key, the cost of a hardware brute-force attack against scrypt is roughly 4000 times greater than the cost of a similar attack against bcrypt (to find the same password), and 20000 times greater than a similar attack against PBKDF2.

[But I'm already using Bcrypt!](http://www.unlimitednovelty.com/2012/03/dont-use-bcrypt.html)


Installation
------------

Add this to your composer.json:

``` json
{
    "require": {
        "usu/scrypt-password-encoder-bundle": "dev-master"
    }
}
```

Then run:

``` bash
$ composer update usu/scrypt-password-encoder-bundle
```

Add the bundle in `app/AppKernel.php`:

``` php
$bundles = array(
    // ...
    new Usu\ScryptPasswordEncoderBundle\UsuScryptPasswordEncoderBundle(),
);
```

And, finally, set the encoder in `app/config/security.yml`:

    security:
        encoders:
            Symfony\Component\Security\Core\User\User:
                id: security.encoder.scrypt

Or, if you are using the excellent `FOSUserBundle`:

    security:
        encoders:
            FOS\UserBundle\Model\UserInterface:
              id: security.encoder.scrypt


Configuration
-------------

You can change the default bundle values (shown below) by adding the following to your `config.yml` file:

    usu_scrypt_password_encoder:
        cpu_cost: 2048
        memory_cost: 4
        parallelization_cost: 1
        key_length: 64

Changing any of the above parameters will result in a different key (auto updating of old passwords is not currently supported).

The parameter `key_length` determines the size in bytes of the derived key; eg: a 64 bytes key will result in a 88 characters string after the automatic base64_encode.

Please refer to the [original documentation](http://framework.zend.com/manual/2.2/en/modules/zend.crypt.key.derivation.html#scrypt-adapter) for dditional informnation.


License
-------

This bundle is released under the MIT license. See the complete license in the bundle:

    Resources/meta/LICENSE

Acknowledgements
----------------

I would like to thank [elnur](https://github.com/elnur) for creating the great ElnurBlowfishPasswordEncoderBundle
that inspired me to release this and [pbhogan](https://github.com/pbhogan/scrypt) from which I borrowed the "Why you should use scrypt" readme section.
