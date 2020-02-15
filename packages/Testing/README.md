# Athenaeum Testing

The Testing package offers various testing utilities, built on top of [Codeception](https://codeception.com/) and [Orchestra Testbench](https://packagist.org/packages/orchestra/testbench). 
It allows you to test Laravel specific components, Laravel's application and offers a few utilities for testing the [Athenaeum Core Application](https://packagist.org/packages/aedart/athenaeum-core). 

Lastly, this package also comes with [Mockery](https://packagist.org/packages/mockery/mockery) and [Faker](https://packagist.org/packages/fzaninotto/faker).

## Exaxmple

```php
use \Aedart\Testing\TestCases\UnitTestCase;

class FuelConsumptionTest extends UnitTestCase
{
    /**
     * @test 
     */
    public function calculatesFuel()
    {
        $faker = $this->getFaker();
        $kilometers = $faker->numberBetween(1, 25);

        $consumption = FuelConsumption::calculate($kilometers);
        
        // ... remaining not shown ...
    }
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
