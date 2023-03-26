---
description: Handling nested dependencies in your Dto
---

# Nested DTOs

Imagine that your `Person` DTO accepts more complex properties, e.g. an address DTO.
Normally, you would manually create that address DTO first, in order to populate your main DTO.
However, if you use the `Dto` abstraction with [Laravel's Service Container](https://laravel.com/docs/9.x/container), populating nested DTOs will be automatically handled for you. 

## Prerequisite

If you are using the `Dto` component within a typical Laravel application, then you do not have to do anything.
A Service Container should already be available.

If you are using this `Dto` package outside a Laravel application, then you must ensure that a Service Container has been initialised.
Consider using this package's [Service Container](../container/) (_a slightly adapted version of Laravel's Service Container_).

[[TOC]]

## Example

The following example shows two DTOs; `Address` and `Person`. 

### Address DTO

```php
class Address extends Dto
{
    protected ?string $street = '';

    public function setStreet(?string $street)
    {
        $this->street = $street;
    }

    public function getStreet() : ?string
    {
        return $this->street;
    }
}
```

### Person DTO

```php
class Person extends Dto implements PersonInterface
{
    protected ?string $name = '';
    
    protected ?int $age = 0;
 
    protected ?Address $address = null;
 
    // ... getters and setters for name and age not shown ... //

     public function setAddress(?Address $address)
     {
         $this->address = $address;
     }
     
     public function getAddress() : ?Address
     {
         return $this->address;
     }
}
```

### Resolving Nested Dependencies

When populating your DTO, just pass in the data as your normally do.
Eventual nested dependencies will automatically be attempted resolved and populated.
Consider the following example:

```php
$data = [
    'name' => 'Arial Jackson',
    'age' => 42,
    
    // Notice that we are NOT passing an instance of Address, but an array instead!
    'address' => [
        'street' => 'Somewhere str. 44'
    ]
];

$person = new Person($data);                                    
$address = $person->getAddress(); // Address DTO instance
```

In the above example, the `Address` DTO is automatically resolved and populated by the [Service Container](https://laravel.com/docs/9.x/container).

::: tip Note
If unable to resolve a nested dependency, the Service Container will fail with a `\Psr\Container\ContainerExceptionInterface`.
:::

## Union Types

If you define properties that accept [union types](https://php.watch/versions/8.0/union-types), then the `Dto` attempt to populate the value accordingly.

### Scalar types

When your property accepts a few scalar types, the `Dto` will ensure that it's data type is cast accordingly.

**Example**

```php
class Person extends Dto
{
    protected string|int|null $id = null;
    
    public function setId(string|int|null $id)
    {
        $this->id = $id;
    }
    
    public function getId(): string|int|null
    {
        return $this->id;
    }
}
```

```php
$person->populate([ 'id' => 'allan-james-jr']);
echo gettype($person->id); // string

$person->populate([ 'id' => 42]);
echo gettype($person->id)); // integer  
```

### Array types

The same is true when you accept an `array`.

**Example**

```php
class Person extends Dto
{
    protected string|array|null $name = null;
    
    public function setName(string|array|null $name)
    {
        $this->name = $name;
    }
    
    public function getName(): string|array|null
    {
        return $this->name;
    }
}
```

```php
$person->populate([ 'name' =>  'Thomas Smith']);
echo gettype($person->name); // string

$person->populate([ 'name' => [ 'Thomas', 'Smith', 'Jr' ]]);
echo gettype($person->name); // array  
```

### Nested DTOs

You may also use define properties that accept multiple nested DTOs. When populated with an `array`, the `Dto` will attempt to find the most suitable match. 
Consider the following example, where the property `reference` accepts two types of populatable DTOs.

**Example**

(_The following examples assume that the order of the accepted types for the setter methods is in the exact same order, as declared for the class properties._)

```php
class Person extends Dto
{
    protected string|null $name = null;
    
    // ... getters / setters not shown
}

class Organisation extends Dto
{
    protected string|null $name = null;
    
    protected string|null $slogan = null;
    
    // ... getters / setters not shown
}

class Record extends Dto
{
    protected string|Person|Organisation|null $reference = null;
    
    // ... getters / setters not shown
}
```

```php
// Reference is a string...
$record->populate([
    'reference' => 'https:://google.com'
]);
echo gettype($record->reference); // string

// Reference becomes a Person...
$record->populate([
    'reference' => [ 'name' => 'Jane Jensen' ]
]);
echo ($record->reference instanceof Person); // true

// Reference becomes an Organisation...
$record->populate([
    'reference' => [ 'name' => 'Acme', 'slogan' => 'Building stuff...' ]
]);
echo ($record->reference instanceof Organisation); // true
```

### Caveats

When populating nested DTOs with arrays, then the `Dto` abstraction will attempt to find the most suitable match.
This means that if you accept two or more DTOs that share property names, e.g. the `$name` property as shown in previous examples, then the DTO will choose the first match.

For instance, if you expect the `$reference` to be an `Organisation`, yet you only provide a `name`, then the first nested DTO that accepts a `name` property will be chosen
In this example, a `Person` instance is created and populated, instead of an `Organisation`.

```php
$record->populate([
    'reference' => [ 'name' => 'Acme' ]
]);
echo ($record->reference instanceof Organisation); // false
```

The reason for this behaviour is due to the order in which the union types are declared (_see `Record` class declaration in previous example_).
To continue the example, when you provide a property that only exists in `Organisation`, then the `Dto` will be able to match it accordingly.

```php
$record->populate([
    'reference' => [ 'slogan' => 'Building stuff...' ]
]);
echo ($record->reference instanceof Organisation); // true
```

The last caveat to be mindful of, is when you choose to declare a property that accepts both an `array` and a DTO.
If the `array` type is stated before your desired nested DTO, then the nested DTO will never be matched. 

```php
class Record extends Dto
{
    protected array|Organisation|null $reference = null;
    
    // ... getters / setters not shown
}

$record->populate([
    'reference' => [ 'slogan' => 'Building stuff...' ]
]);
echo ($record->reference instanceof Organisation); // false
```
