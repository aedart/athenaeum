---
description: How to setup Validation
---

# Setup

[[TOC]]

## Register Service Provider

Register `ValidationServiceProvider` inside your `configs/app.php`. 

```php
return [

    // ... previous not shown ... //

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    */

    'providers' => [

        \Aedart\Validation\Providers\ValidationServiceProvider::class

        // ... remaining services not shown ... //
    ],
];
```

## Publish Assets (optional)

This package comes with a few translation lines. If you wish to customise them, then you to publish this package's assets.
Run `vendor:publish` to publish this package's language files.

```shell
php artisan vendor:publish
```

After the command has completed, you should see the translation file in your `/resources/lang/vendor/athenaeum-validation` directory.

### Publish Assets for Athenaeum Core Application

If you are using the [Athenaeum Core Application](../../core), then run the following command to publish assets:

```shell
php {your-cli-app} vendor:publish-all
```
