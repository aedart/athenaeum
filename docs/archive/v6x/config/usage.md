---
description: How to use Configuration Loader
---
# Load Configuration Files

To load and parse configuration files, set the directory where the files are located and invoke the `load()` method.

```php
$loader->setDirectory('path-to-config-files/');
$loader->load();

$repository = $loader->getConfig();
```

::: tip Note
When used inside a Laravel application, the loaded configuration is merged into the application's existing configuration.
:::

## Nested Directories

The `Loader` will automatically scan through nested directories and attempt to load and parse each found file.
Imagine the following structure.

```
config/
    modules/
        box.json
        circle.yml
    main.ini
    core.php
```

Once these files are loaded, the nested directories then become part of the configuration name.
This means that if you need to access the property `width`, inside `box.json`, then you must state the full name for it.

```php
$loader->setDirectory('config/');
$loader->load();
$repository = $loader->getConfig();

$width = $repository->get('modules.box.width');
```

## Onward

For more information about how to access the loaded configuration, please review [Laravel's documentation](https://laravel.com/docs/9.x/configuration).
