---
description: How to use setup exception handling
---

# Exception Handling

Presumably, your legacy application already has some kind of [error](https://www.php.net/manual/en/function.set-error-handler.php), [exception](https://www.php.net/manual/en/function.set-exception-handler.php) and [shutdown handling](https://www.php.net/manual/en/function.register-shutdown-function.php)[1].
Therefore, **exception handling in Athenaeum Core Application is disabled, by default**.
Should you not be happy with your existing solution, then perhaps the possibilities offered here, could prove beneficial.
At the very least, it might give you some inspiration.

[[TOC]]

[1]: _Error, exception and shutdown handling will be referred to as "exception handling", within this context._

## Laravel's Exception Handling?

In the [limitations section](../README.md#limitations), it has been mentioned that the Athenaeum Core Application does not offer Http Request / Response Handling.
Since Laravel's [Error & Exception Handling](https://laravel.com/docs/7.x/errors#the-exception-handler) mechanism depends on a Http Request and Response, it cannot be used directly with this application. 
More specifically, the `render()` method, in Laravel's [Exception Handler](https://github.com/laravel/framework/blob/6.x/src/Illuminate/Contracts/Debug/ExceptionHandler.php), requires a request and must return a response.
Such cannot be satisfied by the Athenaeum Core Application.
Therefore, a different mechanism is offered - _it is still inspired by that of Laravel!_

## How it Works

This exception handling mechanism uses a pseudo [Composite Pattern](https://designpatternsphp.readthedocs.io/en/latest/Structural/Composite/README.html), where a captured exception is passed through a series of "leaf" exception handlers.
The first handler to return `true`, will stop the process and the exception is considered handled.

Behind the scene, a `CompositeExceptionHandler` is responsible for reporting (_e.g. logging_) and passing captured exceptions to the registered exception handlers.  

```
        Captured Exception
                +
+-----------+   |
| Handler A |   |
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

This kind of approach allows you to split your application's exception handling, into multiple smaller sections of logic (_"leaf" exception handlers_).
Each of these handlers will, _ideally_, only be responsible for dealing with a few exceptions, in contrast to a single large and complex exception handler.

### Error & Shutdown Handling

Whenever a PHP [error](https://www.php.net/manual/en/language.errors.php) has been captured, it will be wrapped into an [`ErrorException`](https://www.php.net/manual/en/class.errorexception) and thrown.
The exception handling mechanism will then capture and process that exception.
Similar logic is applied during PHP's shutdown, in case that an error was encountered. 

## Prerequisite

This exception handling mechanism depends on Laravel's [Log](https://packagist.org/packages/illuminate/log)[2] package, as means of default reporting.
See [Logging chapter](logging.md) for how to install it.

## Enabling Exception Handling

To enable exception handling, edit your `.env` and set the `EXCEPTION_HANDLING_ENABLED` to `true`.

```ini
# ... previous not shown ...

# Exception Handling
EXCEPTION_HANDLING_ENABLED=true
```

## "Last Resort" Handler

The first "leaf" exception handler that you _SHOULD_ create, is a "Last resort" exception handler;
a handler that deals with any kind of exceptions, aka. your fallback mechanism. 

To create a "lead" exception handler, extend the `BaseExceptionHandler` abstraction.
In the following example, a very simplified "last resort" exception handler is shown.

```php
<?php

namespace Acme\Exceptions\Handlers;

use Aedart\Core\Exceptions\Handlers\BaseExceptionHandler;
use Throwable;

class LastResortExceptionHandler extends BaseExceptionHandler
{
    /**
     * @inheritDoc
     */
    public function handle(Throwable $exception): bool
    {
        // When application is handling a Http request...
        if( ! $this->runningInConsole()){
            http_response_code(500);

            echo '<h1>Sorry... but it seems we have some trouble in our end.</h1>';

            return true;
        }

        // When running in console, just output entire exception
        echo (string) $exception;

        return true;
    }
}
```

If at all possible, you _should avoid sending output directly_ via your exception handlers.
Consider assigning your desired Http output to a response handler, if such is possible for you.
In any case, when creating an exception handler, you should try to accommodate the possibility that your application might be running in the console.
This may require a different kind of exception handling.

### Register Your Exception Handler

Once your "leaf" exception handler has been completed, add it's class path in the `handlers` array, which is located in the `/configs/exceptions.php` file.

```php{11}
<?php
return [

    // ... previous not shown ...

    'handlers' => [
        Acme\Exceptions\Handlers\EditorExceptions::class,
        Acme\Exceptions\Handlers\ShoppingExceptions::class,
        Acme\Exceptions\Handlers\NavigationExceptions::class,
        Acme\Exceptions\Handlers\DbExceptions::class,
        Acme\Exceptions\Handlers\LastResortExceptionHandler::class
    ]
];
```

::: tip
Your "last resort" exception handler _SHOULD_ be placed last, in the `handlers` array.
:::

## Reporting

By default, an exception is "reported" by the `CompositeExceptionHandler`, before it is passed through to the registered "leaf" exception handlers.
Within this context, the term reporting means logging exceptions.

### Don't Report

Just like in Laravel's exception handler, if you wish to disable reporting of certain exceptions, add their class paths in the `$dontReport` property.  

```php
<?php

class NavigationExceptionHandler extends BaseExceptionHandler
{
    /**
     * List of exceptions not to be reported
     * 
     * @var string[] 
     */
    protected array $dontReport = [
        \Acme\Routing\Exceptions\RouteNotFoundException::class,
        \Acme\Routing\Exceptions\FileDoesNotExistException::class,
    ];

    public function handle(Throwable $exception): bool
    {
        // ... not shown ...
    }
}
```

## Handler In Action

Imagine that the following entry point encounters a condition, where it must throw an exception.

```php
<?php
require_once __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->run();

// ... your legacy application's logic

if( ! $user->hasSignedIn()){
    throw new \RuntimeException('User is not authenticated');
}

// ... etc

$app->terminate();
$app->destroy();
``` 

The thrown exception is captured and passed through the list of registered "lead" exception handlers, until a handler returns `true`.
Your "last resort" exception handler _SHOULD_ handle any exception, which isn't handled by other registered handlers.

### Application didn't Terminate

When exceptions are thrown and PHP's [native exception handling](https://www.php.net/manual/en/function.restore-exception-handler.php) mechanism kicks in, remaining code is not executed.
In other words, in the above shown example, the last two lines are never reached, should an exception be thrown.
As a consequence of this, any registered termination logic is not executed, by the `terminate()` method.

```php
// ... previous not shown ...

// Never executed, in case of exception thrown...
$app->terminate();
$app->destroy();  
```

Ensuring clean and graceful application shutdown, is a common problem for many applications.
In the next section, a possible solution is explored.

## Graceful Shutdown

Depending upon your registered service providers, or application's overall logic, it may require termination and shutdown logic.
For instance, you may require logic that ensures all open database transactions are committed, or perhaps rolled back in case of exceptions.
Or perhaps you may require logic, that closes the current session, file points, or other resources.
A possible solution is to utilise the `terminating()` method.
It registers callback methods that will be executed, when `terminate()` is invoked.

```php
// Register callback
$app->terminating(function(){
    $session = IoCFacade::tryMake(Session::class);
    $session->close();
});

// ... later in your application ...
$app->terminate(); // Triggers the registered "terminating" callback method
```

Unfortunately, if an exception is thrown, the `terminate()` method might never be reached.
All of your registered callbacks are therefore not invoked.
This could prove problematic, if your application depends on being able to perform ["graceful shutdown"](https://en.wikipedia.org/wiki/Graceful_exit) logic.

### Encapsulate logic via `run()`

A different solution could be, to encapsulate your legacy application's logic via the `run()` method.
It accepts a single callback. If the callback should fail, e.g. an exception is thrown, it will be captured by the `run()` method and passed on to the exception handling mechanism.
Once the exception has been handled, code execution is resumed and the `terminate()` method is triggered.

```php
<?php
require_once __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

$app->run(function($app){

    // E.g. include your legacy application's entry point    
    include 'my_legacy_app_index.php';

});

$app->terminate();
$app->destroy();
```

If the above shown approach is possible for you to implement, then it could contribute towards allowing graceful shutdown.   

### Avoid using `terminating()`? 

One could argue that you should avoid registering callbacks, via the `terminating()` method.
But this might not always be possible.
Imagine that for every request, _if all goes well_, you application needs to commit open database transactions, before closing it's connection gracefully.
It makes sense to use the `terminate()`, in order to achieve such.

```php
$app->terminating(function(){
    $db = IoCFacade::tryMake(Db::class);

    if($db->hasOpenTransations()){
        $db->commit();
    }
    
    $db->close();
});

// ... later in your application ...
$app->terminate();
```

::: tip
Terminating callbacks can also be registered in your Service Provider's [boot method](https://laravel.com/docs/7.x/providers#the-boot-method).

```php
// In your service provider
public function boot(Application $app)
{
    $app->terminating(function($app){
        $db = $app->make(Db::class);
    
        if($db->hasOpenTransations()){
            $db->commit();
        }
        
        $db->close();
    });
}
```
:::

### Use Handles to Cleanup 

Now, if an exception is encountered, then you could use make use of an exception handler;
one which ensures to rollback any open database transactions - _or perform other cleanup routines_ - but avoid actually dealing with any exception!
Any exception would just be passed on to the next registered handler.

```php{5}
<?php

namespace Acme\Db\Cleanup;

use Aedart\Core\Exceptions\Handlers\CleanupHandler;

class RollsBackTransactions extends CleanupHandler
{
    public function cleanup(Throwable $exception): void
    {
        $db = IoCFacade::tryMake(Db::class);
    
        if($db->hasOpenTransations()){
            $db->rollback();
        }
        
        $db->close();
    }
}
```

If such an approach is used, then your `handlers` array could look something similar, to the below illustrated example.
In the top section of the array, you would place handlers that explicitly deal with application cleanup routines, whereas the middle and bottom section of the array would place handlers that deal with exceptions.

```php
<?php
return [

    // ... previous not shown ...

    'handlers' => [
        // Cleanup         
        Acme\Db\Cleanup\RollsBackTransactions::class,
        Acme\Session\Cleanup\ClosesSessions::class,
        Acme\Storage\Cleanup\RemovesFileLock::class,

        // Handles exceptions
        Acme\Exceptions\Handlers\EditorExceptions::class,
        Acme\Exceptions\Handlers\ShoppingExceptions::class,
        Acme\Exceptions\Handlers\NavigationExceptions::class,
        Acme\Exceptions\Handlers\DbExceptions::class,

        // Last resort - if all else fails...
        Acme\Exceptions\Handlers\LastResortExceptionHandler::class
    ]
];
```

Ultimately, the burden of ensuring graceful shutdown falls on your shoulders.
How you go about it, is entirely up to you.
The above illustrated examples is nothing more than a possible solution.

## Onward

Error, exception & shutdown handling is by no means a trivial task.
Perhaps your existing mechanism is sufficient and gets the job done.
If not, perhaps this package's exception handling can offer a suitable alternative.