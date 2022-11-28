---
description: How to setup Http Api
---

# Setup

[[TOC]]

## Register Service Provider

Register `ApiResourceServiceProvider` inside your `config/app.php`. 

```php
return [

    // ... previous not shown ... //

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    */

    'providers' => [

        \Aedart\Http\Api\Providers\ApiResourceServiceProvider::class

        // ... remaining services not shown ... //
    ],
];
```

## Publish Assets

Run `vendor:publish` to publish this package's assets.

```shell
php artisan vendor:publish
```

After the command has completed, you should see the following configuration file in your `/configs` directory:

- `api-resources.php`

### Publish Assets for Athenaeum Core Application

If you are using the [Athenaeum Core Application](../../core), then run the following command to publish assets:

```shell
php {your-cli-app} vendor:publish-all
```
