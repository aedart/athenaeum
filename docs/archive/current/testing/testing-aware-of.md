---
description: How to test Aware-of Helpers
---

# Testing Aware-of Helpers

If you are working with Aware-of Helpers (_"getter-setter-traits"_), then you can easily test them using the `GetterSetterTraitTester`.

## Prerequisite

The helper that you wish to test **MUST** have it's methods declared in accordance with the following:

```shell
set[property-name](?[type] $property);
get[property-name](): ?[type] ;
has[property-name](): bool ;
getDefault[property-name](): ?[type] ;
```

### Example
 
```php

namespace Acme\Helpers;

class NameTrait
{
    protected ?string $name = null;

    public function setName(?string $name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): ?string
    {
        if (!$this->hasName()) {
            $this->setName($this->getDefaultName());
        }
        return $this->name;
    }

    public function hasName(): bool
    {
        return isset($this->name);
    }

    public function getDefaultName(): ?string
    {
        return null;
    }    
}
```

## How to Test Aware-Of Helper

To test the helper, use the `assertGetterSetterTraitMethods` method.

```php
use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Testing\GetterSetterTraitTester;
use Acme\Helpers\NameTrait;

class NameTraitTest extends UnitTestCase
{
    use GetterSetterTraitTester;

    /**
     * @test
     */
    public function canInvokeAllMethods()
    {
        $faker = $this->getFaker();

        $this->assertGetterSetterTraitMethods(
            NameTrait::class,
            $faker->name, // Value to set
            $faker->name // Default value to return
        );
    }
}
```

### Auto Generate Argument Data

As an alternative, you can allow the tester to automatically detect and generate argument data, based on the argument's type.
To do so, use the `assertTraitMethods` method.

```php
use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Testing\GetterSetterTraitTester;
use Acme\Helpers\NameTrait;

class NameTraitTest extends UnitTestCase
{
    use GetterSetterTraitTester;

    /**
     * @test
     */
    public function canInvokeAllMethods()
    {
        $this->assertTraitMethods(NameTrait::class);
    }
}
```

::: warning Caution
The `assertTraitMethods()` method is able to generate data for [scalar-types](http://php.net/manual/en/language.types.intro.php).
When an object is expected, the method will attempt to [mock that object](https://github.com/mockery/mockery).
But, depending on the expected object's constructor arguments, it might fail to be mocked.
If this is the case for you, then you are better of using the `assertGetterSetterTraitMethods()` and manually create the desired mocked object.
:::
