---
description: About the Properties Package
---

# Properties Overload

This package provides means to dynamically deal with inaccessible properties, by implementing some of PHP's [magic methods](https://www.php.net/manual/en/language.oop5.magic.php).

The usage of getters- and setters-methods is enforced, ensuring that if a property is indeed available, its corresponding getter or setter method will be invoked.

The term 'overload', in this context, refers to [PHP’s own definition hereof](http://php.net/manual/en/language.oop5.overloading.php).

## Example

```php
use Aedart\Properties\Overload;

/**
 * @property string|null $name Name of a person
 */
class Person
{
    use Overload;
    
    protected ?string $name = null;
    
    public function getName() : string
    {
	    return $this->name;
    }

    public function setName(string $value)
    {
        if(empty($value)){
            throw new InvalidArgumentException('Provided name is invalid');
        }
        
        $this->name = $value;
        
        return $this;
    }
}
```

Elsewhere in your application, you can invoke the following:

```php
$person = new Person();
$person->name = 'Alin'; // Invokes the setName(...)

echo $person->name;	// Invokes the getName(), then outputs 'Alin'
echo isset($person->name); // Invokes the __isset(), then outputs true

unset($person->name); // Invokes the __unset() and destroys the name property
```
