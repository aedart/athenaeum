---
description: How to setup Events Package
---

# Setup

## Register Service Provider

Register `ListenersViaConfigServiceProvider` inside your `configs/app.php`. 

```php
return [

    // ... previous not shown ... //

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    */

    'providers' => [

        \Aedart\Events\Providers\ListenersViaConfigServiceProvider::class

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

- `events.php`

### Publish Assets for Athenaeum Core Application

If you are using the [Athenaeum Core Application](../core/), then run the following command to publish assets:

```shell
php {your-cli-app} vendor:publish-all
```
