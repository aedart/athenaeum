---
description: How to setup Audit
---

# Setup

[[TOC]]

## Register Service Provider

Register `AuditTrailServiceProvider` in your `config/app.php`. 

```php
return [

    // ... previous not shown ... //

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    */

    'providers' => [

        \Aedart\Audit\Providers\AuditTrailServiceProvider::class

        // ... remaining services not shown ... //
    ],
];
```

## Publish Assets

Run `vendor:publish` to publish package's assets.

```shell
php artisan vendor:publish
```

The package should publish a `config/audit-trail.php` and a migration file inside your `database/migrations` directory.

**Please make sure to configure the audit trail components, before running migrations!**

## Configuration

In your `audit-trail.php` configuration, you will find various settings that your can change as needed.
Amongst them is a map of the Eloquent models for your application user and the "audit trail" model.

```php
<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Audit Trail Model
    |--------------------------------------------------------------------------
    |
    | The Eloquent model to be used for audit trail
    */

    'models' => [

        // Your application's user model
        'user' => \App\Models\User::class,

        // The Audit Trail model
        'audit_trail' => \Aedart\Audit\Models\AuditTrail::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Database table
    |--------------------------------------------------------------------------
    |
    | Name of the database table that contains audit trail
    */

    'table' => 'audit_trails',

   // ... remaining not shown ...
];
```
