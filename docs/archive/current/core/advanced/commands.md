---
description: Console Commands in Core Application
---

# Console Commands

The Console Application that is provided, is a _light version of Artisan_ (Laravel's [Console Application](https://packagist.org/packages/illuminate/console)).
It does not offer all the features that you might now, but it does allow you to register commands and offers Laravel's [Tasks Scheduling](https://laravel.com/docs/6.x/scheduling).

## Create and Register

Once you have your [console command created](https://laravel.com/docs/6.x/artisan#writing-commands), you can register the command via the `configs/commands.php` configuration file.
Please review the [Console Package's documentation](../../console/commands.md) for details.

::: tip Note
This package does not offer Laravel's `make:command` generator utility.
If you wish to create console commands, then you have to do so manually. 
:::