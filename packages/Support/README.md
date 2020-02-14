# Athenaeum Support

Offers complementary components and helpers to [Laravel's Support package](https://packagist.org/packages/illuminate/support).

## Laravel Aware-of Helpers

Traits that offer [Getters and Setters](https://en.wikipedia.org/wiki/Mutator_method) helpers for some of Laravel's core packages. 

These components allow you to manually set and retrieve a Laravel component, e.g. a configuration `Repository`.
Additionally, when no component instance has been specified, it will automatically default to whatever Laravel has bound in the [Service Container](https://laravel.com/docs/6.x/container).

You can think of these helpers as supplements, or alternatives to Laravel's native [Facades](https://laravel.com/docs/6.x/facades).

```php
use \Aedart\Support\Helpers\Config\ConfigTrait;

class MyApiService
{
    use ConfigTrait;    

    public function __construct()
    {
        $config = $this->getConfig();

        $url = $config->get('services.trucks-api.url');
    
        // ... remaining not shown ...
    }
}
```

## Aware-of Properties

In addition to the Laravel Aware-of Helpers, this package comes with an abundance of "aware-of xyz" helpers.
These are generated traits that offer getters and setter methods for various types properties.
They are mostly useful when creating DTOs.

```php
use \Aedart\Support\Properties\Strings\NameTrait;
use \Aedart\Support\Properties\Integers\AgeTrait;

class Person
{
    use NameTrait;
    use AgeTrait;
}  
```

## Documentation

Please read the [official documentation](https://aedart.github.io/athenaeum/) for additional information.

## Repository

The mono repository is located at [github.com/aedart/athenaeum](https://github.com/aedart/athenaeum)

## Versioning

This package follows [Semantic Versioning 2.0.0](http://semver.org/)

## License

[BSD-3-Clause](http://spdx.org/licenses/BSD-3-Clause), Read the LICENSE file included in this package
