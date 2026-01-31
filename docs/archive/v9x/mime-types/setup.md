---
description: How to setup Mime-Types
---

# Setup

[[TOC]]

## Outside Laravel

This package will work without any prior setup, also outside regular Laravel applications.
However, if you wish to get the most of it, you should create appropriate configuration for the `Detector`.

The constructor accepts an array of "profiles", which define a driver and its options.
The following example shows a detector instance with two profiles, a default and a custom. 

```php
use Aedart\MimeTypes\Detector;
use Aedart\MimeTypes\Drivers\FileInfoSampler;

$detector = new Detector([
    // A "default" profile...
    'default' => [
        'driver' => FileInfoSampler::class,
        'options' => [
            'sample_size' => 1048576,
            'magic_database' => null,
        ]
    ],
    
    // Your custom profile...
    'small_file' => [
        'driver' => FileInfoSampler::class,
        'options' => [
            'sample_size' => 512,
            'magic_database' => null,
        ]
    ],
]);
```

You can read more about available options in the [drivers](./drivers) section.

## Inside Laravel

When using this package with Laravel, you can choose to register the package's service provider and publish a configuration.

### Register Service Provider

Register `MimeTypesDetectionServiceProvider` inside your `config/app.php`. 

```php
return [

    // ... previous not shown ... //

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    */

    'providers' => [

        \Aedart\MimeTypes\Providers\MimeTypesDetectionServiceProvider::class

        // ... remaining services not shown ... //
    ],
];
```


### Publish Assets

Run `vendor:publish` to publish this package's configuration.

```shell
php artisan vendor:publish
```

The `config/mime-types-detection.php` configuration will be available in your application.

#### Publish Assets for Athenaeum Core Application

If you are using the [Athenaeum Core Application](../core), then run the following command to publish assets:

```shell
php {your-cli-app} vendor:publish-all
```

### Configuration

Inside the `config/mime-types-detection.php` file, you can create or change "profiles" for the mime-type detector.

```php
<?php

return [

    /*
     |--------------------------------------------------------------------------
     | Default Mime-Type detection profiles
     |--------------------------------------------------------------------------
    */

    'default' => env('MIME_TYPE_DETECTOR', 'default'),

    /*
     |--------------------------------------------------------------------------
     | Detector profiles
     |--------------------------------------------------------------------------
    */

    'detectors' => [

        'default' => [
            'driver' => \Aedart\MimeTypes\Drivers\FileInfoSampler::class,
            'options' => [

                // Default sample size in bytes.
                'sample_size' => 1048576,

                // Magic database to be used.
                'magic_database' => null,
            ]
        ]
    ]
];
```
