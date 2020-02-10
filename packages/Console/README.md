# Athenaeum Console

Offers a way to register [commands](https://laravel.com/docs/6.x/artisan#writing-commands) and [schedules](https://laravel.com/docs/6.x/scheduling#defining-schedules) via configuration.

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

## Documentation

Please read the [official documentation](https://aedart.github.io/athenaeum/) for additional information.

## Repository

The mono repository is located at [github.com/aedart/athenaeum](https://github.com/aedart/athenaeum)

## Versioning

This package follows [Semantic Versioning 2.0.0](http://semver.org/)

## License

[BSD-3-Clause](http://spdx.org/licenses/BSD-3-Clause), Read the LICENSE file included in this package
