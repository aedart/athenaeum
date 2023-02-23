---
description: How to setup Translation Exporter
sidebarDepth: 0
---

# Setup

[[TOC]]

## Register Service Provider

Register `TranslationsExporterServiceProvider`, in your `config/app.php`.

```php
return [

    // ... previous not shown ... //

    /*
    |--------------------------------------------------------------------------
    | Autoload Service Providers
    |--------------------------------------------------------------------------
    */

    'providers' => [

        \Aedart\Translation\Providers\TranslationsExporterServiceProvider::class

        // ... remaining services not shown ... //
    ],
];
```

## Publish Assets

Run `vendor:publish` to publish this package's configuration.

```shell
php artisan vendor:publish
```

You should now have a new `config/translations-exporter.php` configuration available in your application. 

### Publish Assets for Athenaeum Core Application

When using this package with an [Athenaeum Core Application](../../core), then run the following command to publish assets:

```shell
php {your-cli-app} vendor:publish-all
```

## Configuration

Once you have published the translation exporter's assets, you can configure exporters in the `config/translations-exporter.php` file.
Change the profiles as you see fit.

```php
return [

    /*
    |--------------------------------------------------------------------------
    | Default Exporter
    |--------------------------------------------------------------------------
    */

    'default_exporter' => env('DEFAULT_TRANSLATIONS_EXPORTER', 'default'),

    // ...other options not here...

    /*
    |--------------------------------------------------------------------------
    | Exporter Profiles
    |--------------------------------------------------------------------------
    */

    'profiles' => [

        'default' => [
            'driver' => \Aedart\Translation\Exports\Drivers\ArrayExporter::class,
            'options' => [
                'json_key' => '__JSON__'
            ],
        ],

        // ...remaining profiles not shown ...
    ]
];
```
