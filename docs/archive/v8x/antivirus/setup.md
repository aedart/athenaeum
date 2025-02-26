---
description: Setup Antivirus Components
---

# Setup

[[TOC]]

## Register Service Provider

In your `config/app.php`, register `AntivirusServiceProvider` 

```php
return [

    // ... previous not shown ... //

    /*
    |--------------------------------------------------------------------------
    | Autoload Service Providers
    |--------------------------------------------------------------------------
    */

    'providers' => [

        \Aedart\Antivirus\Providers\AntivirusServiceProvider::class

        // ... remaining services not shown ... //
    ],
];
```

## Publish Assets (optional)

Run `vendor:publish` to publish this package's configuration.

```shell
php artisan vendor:publish
```

After the command has completed, you should see `config/antivirus.php` in your application.

### Publish Assets for Athenaeum Core Application

If you are using the [Athenaeum Core Application](../../core), then run the following command to publish assets:

```shell
php {your-cli-app} vendor:publish-all
```

## Configuration

The `config/antivirus.php` file contains the various antivirus profiles. Configure them as you see fit. 

```php
use Aedart\Contracts\Streams\BufferSizes;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Antivirus Scanner
    |--------------------------------------------------------------------------
    */

    'default_scanner' => env('DEFAULT_ANTIVIRUS_SCANNER', 'default'),

    /*
    |--------------------------------------------------------------------------
    | Scanner Profiles
    |--------------------------------------------------------------------------
    |
    | List of available antivirus scanner profiles
    */

    'profiles' => [

        'default' => [
            'driver' => \Aedart\Antivirus\Scanners\ClamAv::class,
            'options' => [
                'socket' => env('CLAMAV_SOCKET', 'unix:///var/run/clamav/clamd.ctl'),
                'socket_timeout' => env('CLAMAV_SOCKET_TIMEOUT', 2),
                'timeout' => env('CLAMAV_SCAN_TIMEOUT', 30),
                'chunk_size' => env('CLAMAV_STREAM_CHUNK_SIZE', BufferSizes::BUFFER_1MB * 10),
            ],
        ],

        'null' => [
            'driver' => \Aedart\Antivirus\Scanners\NullScanner::class,
            'options' => [
                'should_pass' => false,
            ],
        ]
    ]
];

```

