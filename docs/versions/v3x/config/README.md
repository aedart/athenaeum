---
title: Configuration Loader
---

# Loader

The `Loader` component is able to load various types of configuration files and parse them into a Laravel [Repository](https://github.com/laravel/framework/blob/5.8/src/Illuminate/Contracts/Config/Repository.php).

## Supported File Types

| File Extension  |
|-----------------|
| *.ini  |
| *.json  |
| *.php (php array)  |
| *.yml (also *.yaml) (_requires [symfony/yaml](https://github.com/symfony/yaml)_) |

## Setup

### Inside Laravel

If you are using this component inside a typical Laravel application, then all you have to do, is to register `ConfigLoaderServiceProvider`.
In your `configs/app.php`, register the service provider.

```php
return [

    // ... previous not shown ... //

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    */

    'providers' => [

        \Aedart\Config\Providers\ConfigLoaderServiceProvider::class

        // ... remaining services not shown ... //
    ],
];
```

Once you have registered the service, you can obtain an instance of the configuration `Loader` via `ConfigLoaderTrait`.

```php
use Aedart\Config\Traits\ConfigLoaderTrait;

class MyConfigLoadService
{
    use ConfigLoaderTrait;
    
    public function load()
    {
        $loader = $this->getConfigLoader();
    }
}
```

### Outside Laravel

Should you decide to use this component outside a Laravel application, then you need to setup a few dependencies, before able to load configuration.

```php
use Aedart\Config\Loader;
use Aedart\Config\Parsers\Factories\FileParserFactory;
use Illuminate\Config\Repository;
use Illuminate\Filesystem\Filesystem;

$loader = new Loader();

$loader->setConfig(new Repository());
$loader->setFile(new Filesystem());
$loader->setParserFactory(new FileParserFactory());
```

## Load Configuration Files

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
configs/
    modules/
        box.json
        circle.yml
    main.ini
    core.php
```

Once these files are loaded, the nested directories then become part of the configuration name.
This means that if you need to access the property `width`, inside `box.json`, then you must state the full name for it.

```php
$loader->setDirectory('configs/');
$loader->load();
$repository = $loader->getConfig();

$width = $repository->get('modules.box.width');
```

For more information about how to access the loaded configuration, please review [Laravel's documentation](https://laravel.com/docs/5.8/configuration#accessing-configuration-values) or review the `Repository` [source code](https://github.com/laravel/framework/blob/5.8/src/Illuminate/Config/Repository.php).
