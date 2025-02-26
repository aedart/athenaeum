---
description: Logging
sidebarDepth: 0
---

# Logging

The `log()` offers a quick way of logging your requests and responses.

[[toc]]

## Prerequisite

If you are using the Http Client inside your Laravel application, then logging should already be enabled.
But, if you are using this package outside Laravel, then you must register and enable [Laravel's log package](https://packagist.org/packages/illuminate/log). 

```shell
composer require illuminate/log
```

Afterwards, in your `config/app.php`, you need to register the `LogServiceProvider`.
Also, you will require a copy of the `logging.php` configuration file from Laravel's [Repository](https://github.com/laravel/laravel/blob/master/config/logging.php), and place it within your `/configs` directory.
Read more about the configuration in Laravel's [documentation](https://laravel.com/docs/12.x/logging).

```php
return [

    // ... previous not shown ... //

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    */

    'providers' => [

        \Illuminate\Log\LogServiceProvider::class

        // ... remaining services not shown ... //
    ],
];
```

## Example

When using the `log()` method, your outgoing request and received response will be logged as two separate log-entries.

```php
$response = $client
        ->where('date', 'today')
        ->log()
        ->get('/weather');

// "Request" and "Response" log-entries should be available in your log file.
```

## Alternative

The `log()` is intended for a quick way to selectively log requests / responses.
Moreover, it is mostly useful for debugging as it does not offer you much in terms of logging-configuration (_E.g. what channel to use, the log severity to log requests or responses, ...etc_).

If you require more control over how and what is being logged, then it's recommended that you create your own [Middleware](./middleware).
By using a middleware, you have full control of how you wish to log Http Messages.

## Custom callback

Similar to [`debug()` and `dd()`](./debugging), you can provide the `log()` with a custom callback, which will be invoked when request is sent and response received.
When doing so, it's up to you how a request or response should be logged and how.

```php
use Aedart\Contracts\Http\Clients\Requests\Builder;
use Psr\Http\Message\MessageInterface;

$response = $client
        ->where('date', 'today')
        ->log(function(string $type, MessageInterface $message, Builder $builder) {
            // ... log http message ...       
        })
        ->get('/weather');
```
