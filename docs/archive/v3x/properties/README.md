---
title: Properties Overload
---

# Overload

`\Aedart\Properties\Overload` provides means to dynamically deal with inaccessible properties, by implementing PHP's magic methods;
`__get()`, `__set()`, `__isset()`, and `__unset()`.
The usage of getters- and setters-methods is enforced, ensuring that if a property is indeed available, then its corresponding getter or setter method will be invoked. The term 'overload', in this context, refers to [PHP’s own definition hereof](http://php.net/manual/en/language.oop5.overloading.php).

## When to use this

Generally speaking, magic methods can be very troublesome to use.
For the most part, they prohibit the usage of auto-completion in IDEs and if not documented, developers are forced to read large sections of the source code, in order to gain understanding of what’s going on. Depending upon implementation, there might not be any validation, when dynamically assigning new properties to objects, which can break dependent components.
In addition to this, it can also be very difficult to write tests for components that are using such magic methods.

This package will not be able to solve any of the mentioned problems, because at the end of the day, as a developer, you still have to ensure that the code readable / understandable, testable and documented.
Therefore, it is recommend that this component is only used, if and only if, the following are all true;

-	Properties should not be allowed to be dynamically created and assigned to an object, without prior knowledge about them. Thus, properties must always be predefined.
-	Getters and setters must always be used for reading / writing properties
-	You wish to allow access to an object’s properties like such: `$person->age;` but still enforce some kind of control when it's being accessed or set.

## Example

```php
use Aedart\Properties\Overload;

/**
 * @property string $name Name of a person
 */
class Person
{
    use Overload;
    
    protected $name = null;
    
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

// Some place else, in your application, you can then invoke the following:
$person = new Person();
$person->name = 'Alin'; // Invokes the setName(...)

echo $person->name;	// Invokes the getName(), then outputs 'Alin'
echo isset($person->name); // Invokes the __isset(), then outputs true

unset($person->name); // Invokes the __unset() and destroys the name property
```

## Use PHPDoc

When using PHP’s magic methods for overloading properties, it is a very good idea to make use pf PHPDoc's `@property`-tag.
Most IDEs can read it and make use of it to provide auto-completion.
See [phpdoc.org](http://www.phpdoc.org/docs/latest/references/phpdoc/tags/property.html) for additional information.

## Naming Convention

### Property Names

Properties can either be stated in [CamelCase](http://en.wikipedia.org/wiki/CamelCase) or [Snake Case](http://en.wikipedia.org/wiki/Snake_case).

```php
$person->personId = 78; // Valid

$person->category_name = 'Products'; // Valid

// Invalid, because its a mix of both camelCase and underscore
$person->swordFish_length = 63;
```

### Getter / Setter Method Names

Getters and setters follow a most strict naming convention; the must follow [CamelCase](http://en.wikipedia.org/wiki/CamelCase) and be prefixed with `get` for getter methods and `set` for setter methods.
In addition, the `Overload` component uses the following syntax or rules when searching for a property’s corresponding getter or setter:

```
getterMethod = getPrefix, camelCasePropertyName;
getPrefix = "get";

setterMethod = setPrefix, camelCasePropertyName;
setPrefix = "set";

camelCasePropertyName = {uppercaseLetter, {lowercaseLetter}};

uppercaseLetter = "A" | "B" | "C" | "D" | "E" | "F" | "G" | "H" | "I" | "J" | "K"
| "L" | "M" | "N" | "O" | "P" | "Q" | "R" | "S" | "T" | "U" | "V" | "W" | "X"
| "Y" | "Z" ;

lowercaseLetter = "a" | "b" | "c" | "d" | "e" | "f" | "g" | "h" | "i" | "j" | "k"
| "l" | "m" | "n" | "o" | "p" | "q" | "r" | "s" | "t" | "u" | "v" | "w" | "x"
| "y" | "z" ;
```

_Above stated syntax / rules is expressed in [EBNF](http://en.wikipedia.org/wiki/Extended_Backus%E2%80%93Naur_Form)_

#### Examples

```php
// Looks for getPersonId(), setPersonId($value);
$person->personId = 78;

// Looks for getCategoryName() and setCategoryName($value);
$person->category_name = 'Products';
```

## Protected vs. Private properties

By default, only `protected` properties will be accessible (_overloaded_).
This means that `private` declared properties are inaccessible.

```php
use Aedart\Properties\Overload;

class Person
{
    use Overload;

    protected $name = null; // Accessible

    private $age = null; // Inaccessible

    // ...remaining not shown ...
}
```

### Behaviour override

Should you wish to also expose your private declared properties, then this behaviour can be set per object, from an inside scope.

```php
use Aedart\Contracts\Properties\AccessibilityLevels;
use Aedart\Properties\Overload;

class Person
{
    use Overload;

    protected $name = null; // Accessible

    private $age = null;    // Accessible

    public function __construct(){
	    // Change the property accessibility to private
	    $this->setPropertyAccessibilityLevel(AccessibilityLevels::PRIVATE_LEVEL);
    }
}
```
