---
description: About the Console Package
---
# Command and Schedule Registration

This package offers a way to register [commands](https://laravel.com/docs/8.x/artisan) and [schedules](https://laravel.com/docs/8.x/scheduling) via configuration.

It serves as an alternative to the default registration method provided by [Laravel](https://laravel.com).

## Example: Commands

```php
<?php
// configs/commands.php
return [
    \Acme\Console\DatabaseDumpCommand::class,
    \Acme\Console\ExportPicturesCommand::class,
    \Acme\Console\RestoreUserCommand::class,
];
```

## Example: Schedules

```php
<?php
// configs/schedule.php
return [
    'tasks' => [
        \Acme\Tasks\DefinesCacheCleanupTasks::class,
        \Acme\Tasks\DefinesUserTasks::class,
        \Acme\Tasks\DefinesPeriodicNotificationTasks::class
    ]
];
```