---
description: How to setup Streams package
---

# Setup

[[TOC]]

## Outside Laravel

The stream components will work, as-is, even outside a regular Laravel application.
However, depending on your needs, you may have to manually configure a few things before able to achieve desired behaviour.
Where such is relevant, the documentation will make it clear.

## Inside Laravel

To gain the most of this package, you should register its service provider and publish its assets.

### Register Service Provider

In your `config/app.php`, register `StreamServiceProvider`. 

```php
return [

    // ... previous not shown ... //

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    */

    'providers' => [

        \Aedart\Streams\Providers\StreamServiceProvider::class

        // ... remaining services not shown ... //
    ],
];
```


### Publish Assets

Run `vendor:publish` to publish this package's configuration.

```shell
php artisan vendor:publish
```

You should now have a new `config/streams.php` configuration available in your application. 

#### Publish Assets for Athenaeum Core Application

When using this package with an [Athenaeum Core Application](../core), then run the following command to publish assets:

```shell
php {your-cli-app} vendor:publish-all
```

### Configuration

The `config/streams.php` configuration allows you to add and customise different "profiles" for the stream "locking" and "transaction" mechanisms. 
Feel free to thinker with these as you see fit.

_More information about the mentioned mechanisms are covered in later sections._

```php
<?php

return [

    /*
     |--------------------------------------------------------------------------
     | Default Stream profiles
     |--------------------------------------------------------------------------
    */

    'default_lock' => env('STREAM_LOCK', 'default'),

    'default_transaction' => env('STREAM_TRANSACTION', 'default'),

    /*
     |--------------------------------------------------------------------------
     | Lock profiles
     |--------------------------------------------------------------------------
    */

    'locks' => [

        'default' => [
            'driver' => \Aedart\Streams\Locks\Drivers\FLockDriver::class,
            'options' => [
                'sleep' => 10_000,
                'fail_on_timeout' => true
            ]
        ]
    ],
    
    // ... remaining not shown...
];
```
