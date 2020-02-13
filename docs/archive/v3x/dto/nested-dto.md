# Nested DTOs

Imagine that your `Person` DTO accepts more complex properties, e.g. an address DTO.
Normally, you would either manually create the nested DTO or perhaps use some kind of factory to achieve the same.
However, the `Dto` abstraction comes with [Laravel's Service Container](https://laravel.com/docs/5.8/container), meaning that it will automatically attempt to resolve dependencies.

## Prerequisite

If you are using the `Dto` component within a typical Laravel application, then you do not have to do anything.
A Service Container should already be available.

If you are using the `Dto` outside a Laravel application, then you must ensure that a Service Container has been initialised.
Consider using this package's [Service Container](../container/) (_a slightly adapted version of Laravel's Service Container_).

## Example

The following example shows two DTOs; `Address` and `Person`. 

```php
use Aedart\Dto;

class Address extends Dto
{
    protected $street = '';

    public function setStreet(?string $street)
    {
        $this->street = $street;
    }

    public function getStreet() : ?string
    {
        return $this->street;
    }
}

// ------------------------------------------------ //

class Person extends Dto implements PersonInterface
{
    protected $name = '';
    
    protected $age = 0;
 
    protected $address = null;
 
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

// ------------------------------------------------ //
// ... elsewhere in your application ... //

// Data for your Person DTO
$data = [
    'name' => 'Arial Jackson',
    'age' => 42,
    
    // Notice that we are NOT passing in an instance of Address, but an array instead!
    'address' => [
        'street' => 'Somewhere str. 44'
    ]
];

$person = new Person($data);                                    
$address = $person->getAddress();
```

In the above example, [Laravel's Service Container](http://laravel.com/docs/5.5/container) attempts to find and resolve instances that are expected.

Furthermore, the default `Dto` abstraction will attempt to automatically populate that instance.
