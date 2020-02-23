---
description: Console Application
---

# Console

## Create Commands

To create a console command, please review Laravel's [documentation](https://laravel.com/docs/6.x/artisan#writing-commands) 

::: tip Note
This package does not offer Laravel's `make:command` generator utility.
If you wish to create console commands, then you have to do so manually. 
:::

## Register Commands

You can register the command via the `configs/commands.php` configuration file.
Please review the [Console Package's documentation](../../console/commands.md) for details.

### Via Service Provider

Should you require more advanced console command registration, e.g. conditional registration, then you can do so via a Service Provider.
In the `boot()` method, you can invoked the `commands()` method to register your desired commands.

```php
<?php

namespace Acme\Console\Providers;

use Illuminate\Support\ServiceProvider;

class MyConsoleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->commands([
            \Acme\Console\MyCustomCommandA::class,
            \Acme\Console\MyCustomCommandB::class
        ]);
    }
}
```

Once you have completed your service provider, register it in your `/configs/app.php` configuration file.

```php
<?php

return [
    // ... previous not shown ...

    'providers' => [
        \Acme\Console\Providers\MyConsoleServiceProvider::class
    ],
];
```