---
description: How to use Athenaeum Core Application
---

# Integration

In this chapter you will find information, on how to integrate the Athenaeum Core Application into your legacy application.
Please take your time and read through this carefully.

[[TOC]]

## Bootstrap Directory

Create a new directory to contain a application file.
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
Edit these paths as you see fit.

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
    'storagePath' => __DIR__ . '/../storage',
    'publicPath' => __DIR__ . '/../public',
]);
```

::: warning
With the exception of the `publicPath`, all paths shouldn't be publicly available via a browser.
Please configure your web server to deny access to those paths, when requested via Http. 
:::

::: tip
You can read more about the directory structure, e.g. what each directory is intended for, inside [Laravel's documentation](https://laravel.com/docs/8.x/structure#the-bootstrap-directory).
:::

## The Environment File (`.env`)

In your `environmentPath`, create an [environment file](https://laravel.com/docs/8.x/configuration#environment-configuration) (`.env`).
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
| `EXCEPTION_HANDLING_ENABLED`     | Enabling or disabling of Athenaeum Core Application's [exception handling](./usage/exceptions.md). |

## The Console Application (`cli.php`)

Create a `cli.php` file inside your `basePath`. Once again, the naming of the file does not matter.
This file is where Laravel's [Console Application](https://laravel.com/docs/8.x/artisan) (_a light version of Artisan_) is going to be created.

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
The command will publish all assets available assets into your application.
 
```shell
php cli.php vendor:publish-all
```

Once the command has completed, you should have a few configuration files available inside your `/configs` directory.
Details regarding these files are covered in upcoming chapters.
For now, it's important that these are available in your application.

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
The `vendor:publish-all` is inspired by Laravel's publish command, yet it is not intended to offer the exact same features.
Should you require more advanced publish features, then you will have to [create your own](https://laravel.com/docs/8.x/artisan#writing-commands) publish command._
:::

-----

## Make the Application Available

Ideally your legacy application has a single entry point, e.g. a single `index.php`, located in your `/public` directory.
Should this not be the case, don't worry about it. Multiple entry points is covered a bit later.

### Single Entry Point

Inside you `index.php` (_or whatever your entry point might be called_), require the `app.php` file and invoke the `run()` method.

```php
<?php
// Include composer's autoload
require_once __DIR__ . '/../vendor/autoload.php';

// Obtain the application instance
$app = require_once __DIR__ . '/../bootstrap/app.php';

// Run the application
$app->run();

// ... your legacy application logic here ...

// Terminate and destroy the application instance
$app->terminate();

$app->destroy();
```

#### Bootstrap, Register and Boot

In the above example, when the `run()` method is invoked, the Athenaeum Core Application will bootstrap, register and boot it's registered [Service Providers](https://laravel.com/docs/8.x/providers). 
If this is done before your legacy application's logic, then all registered services are made available throughout the remaining of the incoming Http request.

#### Graceful Shutdown

In the bottom path of the example, the `terminate()` and `destroy()` methods are invoked.
This allows registered services to perform [graceful shutdown logic](https://en.wikipedia.org/wiki/Graceful_exit), before the application instance along with it's registered services are destroyed.
Invoking these methods can be omitted, yet it is not advisable.  

### Multiple Entry Points

Should your legacy application have multiple entry points, then you can add additional helper files within your `/bootstrap` directory.
The following illustrates a possible method, of how you could deal with multiple entry points.

#### Header File

Create a new `header.php` file, in which you require the application and invoke the `run()` method.

```php
<?php
// Include composer's autoload
require_once __DIR__ . '/../vendor/autoload.php';

// Obtain the application instance
$app = require_once __DIR__ . '/app.php';

// Run the application
$app->run();
```

#### Footer File

Create a `footer.php` file to handle the application's graceful shutdown.
Invoke the `terminate()` and `destroy()` methods.

```php
<?php
// Terminate and destroy the application instance
if(isset($app)){
    $app->terminate();
    
    $app->destroy(); 
}
```

#### Your Entry Points

Include `header.php` and `footer.php` in each of your entry points.
Ensure that these files are included in the top and bottom part of your entry points.

```php
<?php
// Include the header file
require_once __DIR__ . '/../bootstrap/header.php';

// ... your entry-point logic here ...

// Include the footer file
require_once __DIR__ . '/../bootstrap/footer.php';
```

::: warning Caution
Please make sure to use the [`require_once`](https://www.php.net/manual/en/function.require-once.php) method, to avoid that your bootstrap files (`header.php` and `footer.php`) are not included multiple times, if your application includes entry points into each other.
:::

## Onward

Hopefully, by now you have an application up and running.
For the remainder of this package's documentation, example usages of the major components are illustrated.
Even if your are a seasoned Laravel developer, you should take some time to browse through it.
It might give you some perspectives and helpful information about how this package can be used.
