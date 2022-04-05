---
description: How to setup Maintenance Modes
---

# Setup

[[TOC]]

## Register Service Provider

Register `MaintenanceModeServiceProvider` inside your `configs/app.php`. 

```php
return [

    // ... previous not shown ... //

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    */

    'providers' => [

        \Aedart\Maintenance\Modes\Providers\MaintenanceModeServiceProvider::class

        // ... remaining services not shown ... //
    ],
];
```
