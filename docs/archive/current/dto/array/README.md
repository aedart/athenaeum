---
description: How to create Array Dto
---

# Array DTO

While the `Dto` abstraction is good for situations where you must adhere to interfaces that define lots of getters and
setters, it can be a bit cumbersome to maintain a large number of classes.
This can especially be true, if you must create DTOs to represent all the resources available for a large scale API.

In such situations, the `ArrayDto` abstraction is perhaps better suited.
As it's name suggests, it uses an `array` to keep track of it's properties.
It functions almost the exact same way, as the `Dto` abstraction.

## Creating an Array-Dto

Extend the `ArrayDto` abstraction and declare your DTO's properties, via the `$allowed` variable.

The keys of the `$allowed` variable correspond to your property's name, whereas the values correspond to the property's data type.

Whenever your DTO is populated, it will automatically ensure to [cast](http://php.net/manual/en/language.types.type-juggling.php#language.types.typecasting) the property to it's declared type. 

```php
use Aedart\Dto\ArrayDto;

class Organisation extends ArrayDto
{
    protected array $allowed = [
        'name'          => 'string',
        'employees'     => 'int',
        'hasInsurance'  => 'bool',
        'profitScore'   => 'float',
        'boardMembers'  => 'array',
        'started'       => 'date',
    ];
}
```

## Working with Array-Dto

Once you have created your DTO instance, you can work with it just like the `Dto` abstraction.

```php
$dto = new Organisation([
    'name'          => 'Acme Ltd',
    'employees'     => 134,
    'hasInsurance'  => true,
    'profitScore'   => 33.8,
    'boardMembers'  => [ 'Sawyer', 'Stine', 'Jim' ],
    'started'       => '2018-06-15 10:00:00'
]);

echo $dto->name; // Acme Ltd

$dto['employees'] = 136; // 'employees' property set to 136

echo $dto->toJson(); // Json representation of dto
```

## Supported Types

By default, each declared property is `nullable`, meaning that a property is either of the declared data type or `null`.

The following are the supported data types:

* `string`
* `int`
* `float`, 
* `bool`
* `array`
* `date` (_property is parsed into a [`Carbon`](https://carbon.nesbot.com/docs/) instance_)

::: tip Note
You can change how each type is casted or converted, by overwriting the `castPropertyValue()` method.

Alternatively, you can overwrite each type's individual casting method, e.g. `castAsDate()`, `castAsBoolean()`, `castAsString()`, ...etc.

For more information, please review the source code of `\Aedart\Dto\Partials\CastingPartial` trait, which is used by the `ArrayDto`.
:::

## Nested DTOs

In order to work with [nested DTOs](../nested-dto.md), you must declare their class path in the `$allowed` property.

Other than that, the populate mechanism works in same way, as [previously mentioned](../nested-dto.md).

```php
use Aedart\Dto\ArrayDto;
use Acme\Dto\Address;

class Organisation extends ArrayDto
{
    protected array $allowed = [
        'name'          => 'string',
        'address'       => Address::class,
    ];
}
```

### Union Types

The same union type handling is supported by the `ArrayDto` abstraction, as for the regular `Dto`. 

```php
class Article extends ArrayDto
{
    protected array $allowed = [
        'id' => 'string|int|float|bool|null',
        'content' => 'array|null',
        'createdAt' => 'date|null',
        'author' => ['string', Person::class, Organisation::class, 'null'],
    ];
}
```

Review the [DTO "Union Types" documentation](../nested-dto.md#union-types) for details and additional examples.

## Getters and Setters

Should you require to mutate a property, then you can do so by defining an accessor or mutator method.

The naming rules, for your property getter or setter method, are the same as for [overloading](../../properties/README.md).

```php
use Aedart\Dto\ArrayDto;

class Organisation extends ArrayDto
{
    protected array $allowed = [
        'name'          => 'string', // Type ignored!
    ];
    
    public function setName(?string $name)
    {
        $this->properties['name'] = strtoupper($name);

        return $this;
    }

    public function getName() : ?string
    {
        return $this->properties['name'] ?? null;
    }
}
```

::: warning Warning
When you define accessor or mutator method for a property, it's initial type declaration and casting is ignored.
If special casting or converting is required, then you must manually handle such in your methods.  
:::
