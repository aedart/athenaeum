---
description: Console Application
---

# Console

Laravel's [Console Application](https://laravel.com/docs/8.x/artisan) is used to enable command-line interfacing.
It offers the ability to register and execute custom console commands.

## Create Commands

To create a console command, extend the `Command` class.

```php
<?php

namespace Acme\Console;

use \Illuminate\Console\Command;

class MyCommand extends Command
{
    protected $signature = 'test:my-command';

    protected $description = 'A simple test command';

    public function handle(): int
    {
        $this->output->text('Hi there...');

        return 0;
    }
}
```

For additional information about how to create console commands, please review Laravel's [documentation](https://laravel.com/docs/8.x/artisan#writing-commands). 

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
        // ... your logic / condition check ...

        if($shouldRegisterCommands){
            $this->commands([
                \Acme\Console\MyCustomCommandA::class,
                \Acme\Console\MyCustomCommandB::class
            ]);
        }
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
