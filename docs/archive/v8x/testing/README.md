---
description: About the Testing Package
---

# Introduction

The Testing package offers various testing utilities, built on top of [Codeception](https://codeception.com/) and [Orchestra Testbench](https://packagist.org/packages/orchestra/testbench). 
It allows you to test Laravel specific components, Laravel's application and offers a few utilities for testing the [Athenaeum Core Application](../core). 

Lastly, this package also comes with [Mockery](https://packagist.org/packages/mockery/mockery) and [Faker](https://packagist.org/packages/fakerphp/faker).

## Example

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

