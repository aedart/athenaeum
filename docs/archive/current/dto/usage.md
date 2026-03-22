---
description: How to use DTO
---

# How to use

## Create new DTO class

To create a new DTO, extend the `ArrayDto` abstraction. Specify which properties are allowed and their
corresponding data types (_see [supported types](#supported-types)_).

```php
use Aedart\Dto\ArrayDto;

/**
* Organisation
 *
 * @property string $name
 * @property int $employees
 * @property bool $hasInsurance
 * @property float $profitScore
 * @property string[] $boardMembers
 * @property \Carbon\Carbon $started
 */
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

Later in you application, you can instantiate a new instance and [populate](#populate) it with data. 

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
You can change how each type is cast or converted, by overwriting the `castPropertyValue()` method.

Alternatively, you can overwrite each type's individual casting method, e.g. `castAsDate()`, `castAsBoolean()`, `castAsString()`, ...etc.

For more information, please review the source code of `\Aedart\Dto\Partials\CastingPartial` trait, which is used by the `ArrayDto`.
:::

## Nested DTOs

In order to work with nested DTOs, you must declare their class path as the data type, in the `$allowed` property.

```php
use Aedart\Dto\ArrayDto;

class Address extends ArrayDto
{
    protected array $allowed = [
        'street' => 'string',
        'city' => 'string',
        'zipcode' => 'string',
    ];
}
```

```php
use Aedart\Dto\ArrayDto;
use Acme\Dto\Address;

class Organisation extends ArrayDto
{
    protected array $allowed = [
        'name'          => 'string',
        'address'       => Address::class, // Class path to nested DTO
    ];
}
```

When populating you DTO, simply provide the nested DTO's instance.

```php
$organisation = new Organisation([
    'name' => 'Acme',
    'address' => new Address([
        'street' => 'Somewhere str. 44',
        'city' => 'Copenhagen',
        'zipcode' => 'DK-1050',
    ])
]);
```

### Resolving Nested DTOs from array

It is also possible to populate a nested DTO via an array, without instantiating a new instance.
The `ArrayDto` abstraction will automatically resolve the expected nested DTO and populate it.

```php
$organisation = new Organisation([
    'name' => 'Acme',
    'address' => [
        'street' => 'Somewhere str. 44',
        'city' => 'Copenhagen',
        'zipcode' => 'DK-1050',
    ]
]);

$address = $organisation->address; // Address DTO instance
```

### Union Types

If you define properties that accept [union types](https://php.watch/versions/8.0/union-types), then the `ArrayDto`
will attempt to populate the value accordingly.

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

```php
$article = new Article([
    'id' => 'allan-james-jr'
]);
echo gettype($article->id); // string

$article->id = 42;
echo gettype($person->id)); // integer  
```

For nested DTO's, if you provide an array, _instead of an object instance_, then the "best fitting" nested DTO will
be resolved. This is determined by what properties are allowed and what properties are given. 

```php
$article = new Article([
    'author' => 'Allan James Jr.'
]);
echo gettype($article->author); // string

// ------------------------------------------------------------------- //

// Populates Person DTO, if given properties are supported
$article->author = [
    'name' => 'Allan James Jr.'
];
$author = $person->author; // Person DTO instance  

// ------------------------------------------------------------------- //

// Populates Organisation DTO, if given properties are supported
$article->author = [
    'name' => 'Acme',
    'address' => [
        'street' => 'Somewhere str. 44',
        'city' => 'Copenhagen',
        'zipcode' => 'DK-1050',
    ]
];
$author = $person->author; // Organisation DTO instance
```

### Getters and Setters

If you require a more advanced way to resolve a property, then you can define custom accessor or mutator methods.
Doing will automatically ignore the initial declared data type of the property.

```php
use Aedart\Dto\ArrayDto;

class Organisation extends ArrayDto
{
    protected array $allowed = [
        'name'          => 'string', // Type ignored!
    ];
    
    public function setName(string|null $name)
    {
        $this->properties['name'] = strtoupper($name);

        return $this;
    }

    public function getName() : string|null
    {
        return $this->properties['name'] ?? null;
    }
}
```

```php
$organisation = new Organisation([
    'name' => 'acme',
]);

echo $organisation->name; // ACME
```

::: tip Naming Convention
Method names must follow [CamelCase](http://en.wikipedia.org/wiki/CamelCase) and be prefixed with `get` for accessor
methods (_getters_), and `set` for mutator methods (_setters_).

```
getterMethod = getPrefix, camelCasePropertyName;
getPrefix = "get";

setterMethod = setPrefix, camelCasePropertyName;
setPrefix = "set";

camelCasePropertyName = {uppercaseLetter, {lowercaseLetter}};

uppercaseLetter = "A" | "B" | "C" | "D" | "E" | "F" | "G" | "H" | "I" | "J"
| "K" | "L" | "M" | "N" | "O" | "P" | "Q" | "R" | "S" | "T" | "U" | "V" | "W"
| "X" | "Y" | "Z" ;

lowercaseLetter = "a" | "b" | "c" | "d" | "e" | "f" | "g" | "h" | "i" | "j"
| "k" | "l" | "m" | "n" | "o" | "p" | "q" | "r" | "s" | "t" | "u" | "v" | "w"
| "x" | "y" | "z" ;
```

_Above stated syntax / rules is expressed in [EBNF](http://en.wikipedia.org/wiki/Extended_Backus%E2%80%93Naur_Form)_
:::

## Backed Enums

[`BackedEnum`](https://www.php.net/manual/en/language.enumerations.backed.php) are also supported as a data types.
Note, that basic enums ([`UnitEnum`](https://www.php.net/manual/en/language.enumerations.basics.php)) are not supported.

```php
enum Status: string
{
    case DRAFT = 'draft';
    case PUBLISHED = 'published';
    case UNPUBLISHED = 'unpublished';
    case UNDER_REVIEW = 'review';
}

class Article extends ArrayDto
{
    protected array $allowed = [
        'title' => 'string',
        'status' => Status::class
    ];
}
```

```php
$article = new Article([
    'name' => 'Long Island Journey',
    'status' => Status::DRAFT
]);

// Or, use enum case value...
$article->status = 'review'; // Auto-resolved to UNDER_REVIEW Status enum case
```

## Populate

To populating your DTO with data, provide the constructor with an array, using the `populate()` method, or from a
JSON string using the `fromJson()` method.

::: tip Note
Getters and setter methods are automatically invoked for each property, if available.
:::

### Constructor

```php
$person = new Person([
    'name' => 'Carmen Rock',
    'age'  => 25
]);

echo $person->name; // Carmen Rock
```

### `populate()`

```php
$person->populate([
    'name' => 'Timmy Jones',
    'age'  => 32
]);

echo $person->name; // Timmy Jones
```

### JSON

```php
$json = '{"name":"Miss Mossie Wehner Sr.","age":28}';

$person = Person::fromJson($json);

echo $person->name; // Miss Mossie Wehner Sr.
```

## Export

By default, the `ArrayDto` can be exported to an array, using the `toArray()` method.

```php 
$properties = $person->toArray();
var_dump($properties);  
```

```shell
array(2) {
  ["name"]=> string(5) "Timmy"
  ["age"]=> int(19)
}
```

## JSON

The `ArrayDto` abstraction inherits from [`JsonSerializable`](http://php.net/manual/en/class.jsonserializable.php).
This means that you can use [`json_encode()`](https://www.php.net/manual/en/function.json-encode.php) directly on your DTO instance.

```php
$person = new Person([
    'name' => 'Rian Dou',
    'age' => 29
]);

echo json_encode($person);
```

``` json
{
    "name":"Rian Dou",
    "age":29
}
```

The same can be achieved via the `toJson()` method.

```php
$person = new Person([
    'name' => 'Rian Dou',
    'age' => 29
]);

echo $person->toJson(); // The same as invoking json_encode($person);
```

## Serialization

You can also [serialise](https://www.php.net/manual/en/function.serialize) and [unserialise](https://www.php.net/manual/en/function.unserialize.php) your DTOs, using PHP's native methods.

```php
$serialised = serialize($person);
```

```php
$person = unserialize($serialised);
```