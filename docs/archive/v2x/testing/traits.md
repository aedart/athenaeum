# Traits

If you are working with "getter-setter-traits" (aware-of components), then you can easily test those using the `GetterSetterTraitTester`.

## Getter-Setter Trait

The trait in question must have the following methods defined:

```shell
set[property-name](?[type] $property);
get[property-name](): ?[type] ;
has[property-name](): bool ;
getDefault[property-name](): ?[type] ;
```

### Trait Example
 
```php
class NameTrait
{
    protected $name = null;

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

## Testing the Trait

To test the trait, use the `assertGetterSetterTraitMethods` method inside your test.

```php
use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Testing\GetterSetterTraitTester;

class NameTraitTest extends UnitTestCase
{
    use GetterSetterTraitTester;

    /**
     * @test
     */
    public function canAssertTraitMethods()
    {
        $this->assertGetterSetterTraitMethods(
            NameTrait::class,
            $this->faker->name,
            $this->faker->name
        );
    }
}
```

## Auto Generate Argument Data

As an alternative, you can allow the tester to automatically detect and generate argument data, based on the argument's type.
To do so, use the `assertTraitMethods` method.

```php
use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Testing\GetterSetterTraitTester;

class NameTraitTest extends UnitTestCase
{
    use GetterSetterTraitTester;

    /**
     * @test
     */
    public function canAssertTraitMethods()
    {
        $this->assertTraitMethods(NameTrait::class);
    }
}
```

::: warning
Method is only able to generate data for [scalar-types](http://php.net/manual/en/language.types.intro.php) and [Mocks](https://github.com/mockery/mockery) for objects.
This feature should be considered experimental!
:::
