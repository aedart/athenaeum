---
description: About the Service Package
---

# Service Registrar

The Service Registrar component is able to register and boot [Service Providers](https://laravel.com/docs/7.x/providers).

```php
use \Aedart\Service\Registrar;

$registrar = new Registrar($application);
$registrar->register(\Acme\Warehouse\Providers\WarehouseServiceProvider::class);

$registrar->bootAll();
```

::: warning Caution
**This package is intended to be used outside a normal Laravel application!**
There is no need for you to use it within your regular application, because Laravel already [provides such functionality](https://laravel.com/docs/7.x/providers#registering-providers).

Initially this component has been designed to be to be used by the [Athenaeum Core Application](../core).
However, it can be used on it's own, provided that you have an application available that implements the `\Illuminate\Contracts\Foundation\Application` interface. 
:::
