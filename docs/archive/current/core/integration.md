---
description: How to use Athenaeum Core Application
---

# How to Integrate

In this chapter you will find information on how to integrate the Athenaeum Core Application into your legacy application.
Please take your time and read through this carefully.

[[TOC]]

## Bootstrap Directory

Create a new directory to contain the application file.
The directory _SHOULD_ not be publicly available via the browser.
You can call this directory for `bootstrap` or whatever makes sense to you.

```shell
/bootstrap
```

## The Application file (`app.php`)

Inside your newly created `/bootstrap` directory, create a `app.php` file (_The filename does not matter_).
This application file will create a new `Application` instance.
It accepts an `array` of various directory paths.
These paths are used throughout the `Application` and many of Laravel's components.
It is therefore important that these directories exist.
Edit these paths as you see fit. But keep in mind these paths are **not intended to be publicly available** via the browser.

```php
<?php
// Create application instance, set the paths it must use
return new \Aedart\Core\Application([
    'basePath' => dirname(__DIR__),
    'bootstrapPath' => dirname(__DIR__),
    'configPath' => __DIR__ . '/../configs',
    'databasePath' => __DIR__ . '/../database',
    'environmentPath' => __DIR__ . '/../',
    'resourcePath' => __DIR__ . '/../resources',
    'storagePath' => __DIR__ . '/../storage'
]);
```

::: tip
You can read more about the directory structure, e.g. what each directory is intended for, inside [Laravel's documentation](https://laravel.com/docs/6.x/structure#the-bootstrap-directory).
:::

## The Environment File (`.env`)

In your `environmentPath`, create an [environment file](https://laravel.com/docs/6.x/configuration#environment-configuration) (`.env`).
At the very minimum, it should contain the following:

```ini
# Application name
APP_NAME="Athenaeum"

# Application environment
APP_ENV="production"

# Exception Handling
EXCEPTION_HANDLING_ENABLED=false
```

| Name          | Description   |
| ------------- |-------------|
| `APP_NAME`    | Your application's name. |
| `APP_ENV`     | The application's environment, e.g. "production", "testing", "development"...etc. |
| `EXCEPTION_HANDLING_ENABLED`     | Enabling or disabling of Athenaeum Core Application's exception handling (_details are covered in a later section_). |

## The Console Application (`cli.php`)

Create a `cli.php` file inside your `basePath`. Once again, the naming of the file does not matter.
This file is where Laravel's [Console Application](https://laravel.com/docs/6.x/artisan) (_a light version of Artisan_) is going to be created.

```php
<?php
// Include composer's autoloader
require __DIR__ . '/vendor/autoload.php';

// Obtain application instance
$app = require_once __DIR__ . '/bootstrap/app.php';

// Create "Console Kernel" instance
$kernel = $app->make(\Aedart\Contracts\Console\Kernel::class);

// Run the application - handle input, assign output
$status = $kernel->handle(
    $input = new \Symfony\Component\Console\Input\ArgvInput(),
    new \Symfony\Component\Console\Output\ConsoleOutput()
);

// Terminate and exist with status code
$kernel->terminate($input, $status);

exit($status);
```

By now, you should be able to run the Console Application. Try the following:

```shell
php cli.php
```

You should see an output similar to this:

```shell
Athenaeum (via. Laravel Artisan ~ illuminate/console 6.16.0) 4.0.0

Usage:
  command [options] [arguments]

Options:
  -h, --help            Display this help message
  -q, --quiet           Do not output any message
  -V, --version         Display this application version
      --ansi            Force ANSI output
      --no-ansi         Disable ANSI output
  -n, --no-interaction  Do not ask any interactive question
      --env[=ENV]       The environment the command should run under
  -v|vv|vvv, --verbose  Increase the verbosity of messages: ...

// ... remaining not shown ...
```

## Publish Assets

This package, along with it's dependencies, requires certain assets in order to be fully functional, e.g. configuration files.
To make these assets available in your legacy application, you need to run the `vendor:publish-all` command, via your Console Application (`cli.php`).
 
```shell
php cli.php vendor:publish-all
```

Once the command has completed, you should have a few configuration files available inside your `/configs` directory.
Some of these configuration files are covered at a later point, in other chapters.
For now, it's important that these are available to your application.

```shell
/configs
    app.php
    cache.php
    commands.php
    events.php
    exceptions.php
    schedule.php
```

::: tip Note
_If you are familiar with Laravel's `vendor:publish` command, you will immediately notice that this publish assets command does not offer the same features, as the one provided by Laravel.
The `vendor:publish-all` is inspired by Laravel's publish command, yet it is not intended to offer the exact same features._

_Should you require more advanced publish features, then you will have to [create your own](https://laravel.com/docs/6.x/artisan#writing-commands) publish command._
:::

-----

## Make the Application Available

TODO: ... The following are a few incomplete notes:

7. Include application in your entry point, e.g. inside your `index.php`
Example on how.

alternative setup, header + footer files?

Isolated testing notes:

```shell
cd /public
php -S localhost:8000
```

Enter localhost:8000/index.php

-----------------------
Other topics:
    Register Service Providers, e.g. Laravel's or Own
    Exception Handling - should be the first?
        What about logging????
    The run method - alternative setup

Advanced:
    Ext. Application
    Custom Bootstrappers
    Custom Service Providers?