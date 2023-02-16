---
description: How to setup Configuration Loader
---
# Setup

## Inside Laravel

If you are using this component inside a typical Laravel application, then all you have to do, is to register `ConfigLoaderServiceProvider`.
This can be done in your `config/app.php` file.

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

## Outside Laravel

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
