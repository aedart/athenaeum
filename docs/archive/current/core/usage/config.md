---
description: How to use configuration files in Core Application
---

# Configuration

By now you should already know, all of your application's configuration is located within your `/configs` directory - or whatever [path you have chosen](../integration.md).

## Get and Set Values

The following shows how to obtain the configuration repository, obtain a value and how to set a value

```php
$config = $app->get('config');

$value = $config->get('app.name');

$config->set('app.name', 'Acme Inc. Application');
```

## Behind The Scene

Laravel's [Configuration Repository](https://github.com/laravel/framework/blob/6.x/src/Illuminate/Config/Repository.php) is used to hold the configuration, whilst the [Athenaeum Config Loader](../../config) is used to load and populate the Repository.
This offers you slightly different configuration possibilities, than in a regular Laravel application.
Amongst such possibilities, is the the ability to use nested directories, within your `/configs` directory.
It also supports various file types.

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