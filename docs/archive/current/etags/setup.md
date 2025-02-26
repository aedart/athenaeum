---
description: How to setup ETags Package
sidebarDepth: 0
---

# Setup

## Service Provider

Register `ETagsServiceProvider` inside your `config/app.php`. 

```php
return [

    // ... previous not shown ... //

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    */

    'providers' => [

        \Aedart\ETags\Providers\ETagsServiceProvider::class

        // ... remaining services not shown ... //
    ],
];
```

## Publish Assets

Run `vendor:publish` to publish this package's assets.

```shell
php artisan vendor:publish
```

Once completed, you should have the following configuration file in your `/configs` directory:

- `etags.php`

### Publish Assets for Athenaeum Core Application

If you are using the [Athenaeum Core Application](../core/), then run the following command to publish assets:

```shell
php {your-cli-app} vendor:publish-all
```

## Configuration

In the `config/etags.php` you can create or change the "profiles" for the Etags Generator.

```php
return [

    /*
    |--------------------------------------------------------------------------
    | Default ETag Generator
    |--------------------------------------------------------------------------
    */

    'default_generator' => env('DEFAULT_ETAG_GENERATOR', 'default'),

    /*
    |--------------------------------------------------------------------------
    | Generator Profiles
    |--------------------------------------------------------------------------
    */

    'profiles' => [

        'default' => [
            'driver' => \Aedart\ETags\Generators\GenericGenerator::class,
            'options' => [

                // Hashing algorithm to be used for ETags flagged
                // as "weak" (weak comparison)
                'weak_algo' => 'crc32',

                // Hashing algorithm to be used for ETags
                // NOT flagged as "weak" (strong comparison)
                'strong_algo' => 'sha1',
            ],
        ],
    ]
];
```