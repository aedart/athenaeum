---
description: How to setup Filters Package
---

# Setup

## Register Service Provider

Register `FiltersServiceProvider` inside your `config/app.php`. 

```php
return [

    // ... previous not shown ... //

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    */

    'providers' => [

        \Aedart\Filters\Providers\FiltersServiceProvider::class

        // ... remaining services not shown ... //
    ],
];
```