---
description: How to use setup exception handling
---

# Exception Handling

There is a great chance, that your legacy application already has some kind of [error](https://www.php.net/manual/en/function.set-error-handler.php), [exception](https://www.php.net/manual/en/function.set-exception-handler.php) and [shutdown handling](https://www.php.net/manual/en/function.register-shutdown-function.php)[1].
Therefore, **exception handling is disabled, by default**. Otherwise it might conflict with your existing.
Even so, should you not be happy with your existing mechanism, then perhaps the possibilities offered by this could prove beneficial.
At the very least, it might give your some inspiration.

[[TOC]]

[1]: _Error, exception and shutdown handling will be referred to as "exception handling" within this context._

## Laravel's Exception Handling?

In the [limitations section](../README.md#limitations), it has been mentioned that the Athenaeum Core Application does not offer Http Request / Response Handling.
Since Laravel's [Error & Exception Handling](https://laravel.com/docs/6.x/errors#the-exception-handler) mechanism depends on a Http Request and Response, it cannot be used directly with this application. 
More specifically, the `render()` method, in Laravel's [Exception Handler](https://github.com/laravel/framework/blob/6.x/src/Illuminate/Contracts/Debug/ExceptionHandler.php) requires a request and returns a response.
This cannot be satisfied by the Athenaeum Core Application.
Therefore, a different mechanism is offered - _it is still inspired by that of Laravel!_

## How it Works

This exception handling mechanism uses a pseudo [Composite Pattern](https://designpatternsphp.readthedocs.io/en/latest/Structural/Composite/README.html), where a captured exception is passed through a series of exception handlers.
The first handler to return `true`, will stop the process and the exception is considered handled.

Behind the scene, a `CompositeExceptionHandler` is responsible for reporting (_e.g. logging_) and passing captured exceptions to the registered exception handlers.  

```
        Captured Exception

+-----------+
| Handler A |   +
+-----------+   |
| Handler B |   |
+-----------+   |
| Handler C |   |
+-----------+   |
  ...           |
+-----------+   v
| Handler X |
+-----------+
```

This kind of approach allows you to split your application's exception handling, into multiple smaller handlers.
Each of these handlers will, _ideally_, only be responsible for dealing with a few exceptions, in contrast to a single complex exception handler.

## Prerequisite

The exception handling mechanism depends on Laravel's [Log](https://packagist.org/packages/illuminate/log)[2] package.
You will need to require it.

```shell
composer require illuminate/log
```

[2]: _The `illuminate/log` package uses [MonoLog](https://github.com/Seldaek/monolog)._

### Logger Configuration

You need to copy the `logging.php` configuration file from Laravel's [Repository](https://github.com/laravel/laravel/blob/master/config/logging.php), and place it within your `/configs` directory.
You can read more about the configuration in Laravel's [documentation](https://laravel.com/docs/6.x/logging).

### Register `LogServiceProvider`

In your `/configs/app.php`, add the class path to `LogServiceProvider` in your `providers` array.

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

## Enabling Exception Handling

To enable exception handling, edit your `.env` and set the `EXCEPTION_HANDLING_ENABLED` to `true`.

```ini
# ... previous not shown ...

# Exception Handling
EXCEPTION_HANDLING_ENABLED=true
```

## Create "Last Resort" Handler

TODO... what is this, why is it a good idea.
What about sending output?... Might not be any other alternative

## Handler In Action

TODO... Demonstration of the handler 
...Add more handlers...

## Graceful Shutdown

TODO... Why the above stated is a bit "problematic" vs. using the `run()`.
Also, output is might already be sent...

## Reporting

TODO... How does this work, how to set "don't report"