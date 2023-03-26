---
description: Container destroy method
---

# `destroy()`

This method ensures that all bindings are unset, including those located within the [`Facade`](https://laravel.com/docs/7.x/facades).
In addition, when invoked the `Facade`'s application is also unset.

```php
use \Aedart\Container\IoC;

$ioc = IoC::getInstance();

// ...later in your application or test
$ioc->destroy();
```

