---
description: How to add Logging
---

# Logging

Some of Laravel's services depend on the [Logging](https://packagist.org/packages/illuminate/log) package¹.
Should you stumble across such a dependency, then you might be required to install it, in order to get the service to work as intended.

¹: _The `illuminate/log` package uses [MonoLog](https://github.com/Seldaek/monolog)._

## How to install

```shell
composer require illuminate/log
```

## Logger Configuration

Copy the `logging.php` configuration file from Laravel's [Repository](https://github.com/laravel/laravel/blob/master/config/logging.php), and place it within your `/configs` directory.
You can read more about the configuration in Laravel's [documentation](https://laravel.com/docs/10.x/logging).

## Register `LogServiceProvider`

Add the class path to `LogServiceProvider` in your `providers` array, in your `/config/app.php` configuration file.

```php
<?php
return [
    // ... previous not shown ...

    'providers' => [
        \Illuminate\Log\LogServiceProvider::class,
    ],

    // ... remaining not shown ...
];
```

At this point, you should have logging available in your application.

::: tip Folder Permissions
If you chose a log-profile that stores log entries in files, then please ensure that storage directory has the correct permissions.
For instance, if you chose to store log-files in the `/storage/logs` directory, you _could_ change the permissions to the following:

```shell
chown -R www-data:www-data /storage/logs
```

_The above example applies to Linux environments. Please seek appropriate guidance regarding read/write permissions, if you work on a difference type of server environment._
:::

## Usage

### Via `$app`

If your `$app` is available, then use the `make()` method to obtain the logger instance.

```php
<?php
// Obtain logger instance
$logger = $app->make('log');

$logger->info('Logger works great');
```

### Via `Log` Facade

You can also use Laravel's `Log` [Facade](https://laravel.com/docs/10.x/facades). 

```php
<?php
use Illuminate\Support\Facades\Log;

Log::warning('User is missing contact information', [ 'user' => $user ]);
```

### Via Aware-of Helper

Alternatively, you can make use of the `Log` [Aware-of Helper](../../support/laravel).

```php
<?php
use Aedart\Support\Helpers\Logging\LogTrait;

class DeviceRegistrationController
{
    use LogTrait;

    public function index()
    {
        // ... previous not shown ...

        $logger = $this->getLog();

        $logger->debug('Device requesting registration', [ 'device' => '...' ]);

        // ... Remaining not shown ...
    }
}
```
