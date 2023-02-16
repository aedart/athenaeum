---
description: How to use configuration files in Core Application
---

# Configuration

All of this package's configuration is located within your `/configs` directory (_this path [can be specified](../integration.md) in your application instance_).

## Get and Set Values

There are many ways to obtain the configuration repository.
The following only illustrates a single possibility.
For additional possibilities, consider reviewing the [Laravel Helpers](../../support/laravel) package.

```php
$config = $app->get('config');

$value = $config->get('app.name');

$config->set('app.name', 'Acme Inc. Application');
```

## Behind The Scene

Laravel's [Configuration Repository](https://github.com/laravel/framework/blob/6.x/src/Illuminate/Config/Repository.php) is used to hold the configuration, whilst the [Athenaeum Config Loader](../../config) is used to load and populate the Repository.
This offers you slightly different configuration possibilities, than within a regular Laravel application.
Amongst such possibilities, is the the ability to use nested directories, within your `/configs` directory.
Also the loader supports various file types and the possibility to add your own [custom file parsers](../../config/custom.md).

```
/configs
    /services/
        MyServiceA.json
        MyServiceB.ini
        MyServiceC.yml
    app.php

    // ... remaining not shown ...
```

See [Package documentation](../../config) for more information.