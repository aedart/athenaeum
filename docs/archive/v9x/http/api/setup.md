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

**Note**: _The [`ETagsServiceProvider`](../../etags/README.md) is automatically registered, when you register `ApiResourceServiceProvider`._

## Publish Assets

Run `vendor:publish` to publish this package's assets.

```shell
php artisan vendor:publish
```

After the command has completed, you should see the following configuration files in your `/configs` directory:

- `api-resources.php`
- `etags.php` (_See [ETags package](../../etags/README.md) for additional information_)

### Publish Assets for Athenaeum Core Application

If you are using the [Athenaeum Core Application](../../core), then run the following command to publish assets:

```shell
php {your-cli-app} vendor:publish-all
```
