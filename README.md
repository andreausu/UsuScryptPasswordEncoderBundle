UsuScryptPasswordEncoderBundle
==============================

Scrypt password encoder for Symfony2

Requirements
------------

- php >= 5.3.3

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

Usage
-----


License
-------

This bundle is released under the MIT license. See the complete license in the bundle:

    Resources/meta/LICENSE

Acknowledgements
----------------

I would like to thank [elnur](https://github.com/elnur) for creating the great ElnurBlowfishPasswordEncoderBundle
that inspired me to release this.
