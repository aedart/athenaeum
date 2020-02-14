# Athenaeum Service

The Service Registrar component is able to register and boot [Service Providers](https://laravel.com/docs/6.x/providers).

```php
use \Aedart\Service\Registrar;

$registrar = new Registrar($application);
$registrar->register(\Acme\Warehouse\Providers\WarehouseServiceProvider::class);

$registrar->bootAll();
```

## Caution

**This package is intended to be used outside a normal Laravel application!**
There is no need for you to use it within your regular application, because Laravel already [provides such functionality](https://laravel.com/docs/6.x/providers#registering-providers).

Initially this component has been designed to be to be used by the [Athenaeum Core Application](https://packagist.org/packages/aedart/athenaeum-core).
However, it can be used on it's own, provided that you have an application available that implements the `\Illuminate\Contracts\Foundation\Application` interface. 

## Documentation

Please read the [official documentation](https://aedart.github.io/athenaeum/) for additional information.

## Repository

The mono repository is located at [github.com/aedart/athenaeum](https://github.com/aedart/athenaeum)

## Versioning

This package follows [Semantic Versioning 2.0.0](http://semver.org/)

## License

[BSD-3-Clause](http://spdx.org/licenses/BSD-3-Clause), Read the LICENSE file included in this package
