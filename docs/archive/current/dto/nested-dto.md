---
description: Handling nested dependencies in your Dto
---

# Nested DTOs

Imagine that your `Person` DTO accepts more complex properties, e.g. an address DTO.
Normally, you would manually create that address DTO first, in order to populate your main DTO.
However, if you use the `Dto` abstraction with [Laravel's Service Container](https://laravel.com/docs/8.x/container), populating nested DTOs will be automatically handled for you. 

## Prerequisite

If you are using the `Dto` component within a typical Laravel application, then you do not have to do anything.
A Service Container should already be available.

If you are using this `Dto` package outside a Laravel application, then you must ensure that a Service Container has been initialised.
Consider using this package's [Service Container](../container/) (_a slightly adapted version of Laravel's Service Container_).

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

In the above example, the `Address` DTO is automatically resolved and populated by the [Service Container](https://laravel.com/docs/8.x/container).

::: tip Note
If unable to resolve a nested dependency, the Service Container will fail with a `\Psr\Container\ContainerExceptionInterface`.
:::

