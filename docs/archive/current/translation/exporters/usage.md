---
description: How to use Translation Exporter
sidebarDepth: 0
---

# How to use

At the top level, a `Manager` is responsible for keeping track of your exporters.

[[TOC]]

## Obtain Manager

The translation exporter `Manger` can be obtained via the `TranslationsExporterManagerTrait`.

```php
use Aedart\Translation\Traits\TranslationsExporterManagerTrait;

class MyController
{
    use TranslationsExporterManagerTrait;
    
    public function index()
    {
        $manager = $this->getTranslationsExporterManager();
        
        // ..remaining not shown...
    }
}
```

Once you have your manager, you can request an `Exporter` instance, which will perform the actual exporting of translations.

```php
$exporter = $manager->profile(); // Default profile
```

To obtain a specific `Exporter`, specify the profile name as argument.

```php
$exporter = $manager->profile('lang_js');
```

## Export Translations

To export the application's translations, invoke the `export()` method.
It accepts the following arguments:

 * `string|array $locales` (_optional_) Locales to export. Wildcard (_*_) = all locales.
 * `string|array $groups` (_optional_) Groups to export. Wildcard (_*_) = all groups, incl. namespaced groups, e.g. `'courier::messages'`.

```php
// All available translations, for all locales...
$all = $exporter->export();

// English translations only...
$englishOnly = $exporter->export('en');

// En-uk, of the auth and validation groups
$uk = $exporter->export('en-uk', [ 'auth', 'validation' ]);

// Namespaced group (from a package)...
$acme = $exporter->export('be', 'acme::users');
```

The output of the `export()` method depends on the chosen profile's [driver](./drivers/README.md).

## Paths and Translations

Available locales and groups are automatically detected, based on the `paths` option (_in your `config/translations-exporter.php`_), 
as well as registered namespaced translations and paths to JSON files, in Laravel's translation loader.

If you wish to export translations from 3rd party packages, then you have the following options:

1. Register 3rd party service provider to load translations. 
2. Publish packages' resource (_if translations are published_)
3. Or, manual registration of translations (_see below_)

To use translations from packages, without having to register their service providers, you can register them in the configuration:  

```php
<?php

return [
    // ...previous not shown...
    
    /*
    |--------------------------------------------------------------------------
    | Namespaces and Json
    |--------------------------------------------------------------------------
    |
    | Register namespaced translations and paths to JSON translations. Use this
    | when you want to use 3rd part translations without having to register
    | their service providers.
    */

    'namespaces' => [
        'acme' => realpath(__DIR__ . '/../vendor/acme/package/lang'),
    ],

    'json' => [
        realpath(__DIR__ . '/../vendor/acme/package/lang')
    ],

    // ...remaining not shown ...
];

```
 
Consequently, when you manually register namespaced translations and paths to JSON translations, then these will be made available in your application!
