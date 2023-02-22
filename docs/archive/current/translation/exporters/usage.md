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

::: tip Note
Each exporter offers a `paths` option, in which you can specify where to look for translations files.
Those paths are used for detecting available locales and translation groups.
Yet, **ONLY** translations that are [**REGISTERED** in the application](https://laravel.com/docs/10.x/packages#language-files) are exported.

The reason for this behaviour, is to ensure that correct [package overwrites](https://laravel.com/docs/10.x/localization#overriding-package-language-files) are exported, as intended.
Laravel's translation loader component does this, so you do not have to worry about it.
:::