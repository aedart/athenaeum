# Property overloading

Each defined property is accessible in multiple ways, if a getter and or setter method has been defined for that given property.

For additional information, please read about [Mutators and Accessor](https://en.wikipedia.org/wiki/Mutator_method), [PHP's overloading](http://php.net/manual/en/language.oop5.overloading.php),
and [PHP's Array-Access](http://php.net/manual/en/class.arrayaccess.php)

```php
// Create a new instance of your DTO
$person = new Person();

// Name can be set using normal setter methods
$person->setName('John');

// But you can also just set the property itself
$person->name = 'Jack'; // Will automatically invoke setName()

// And you can also set it, using an array-accessor
$person['name'] = 'Jane'; // Will also automatically invoke setName()

// ... //

// Obtain age using the regular getter method
$age = $person->getAge();

// Can also get it via invoking the property directly
$age = $person->age; // Will automatically invoke getAge()

// Lastly, it can also be access via an array-accessor
$age = $person['age']; // Also invokes the getAge()
```

::: tip
If you are using a modern [IDE](https://en.wikipedia.org/wiki/Integrated_development_environment), then it will most likely support [PHPDoc](http://www.phpdoc.org/).

By adding a [`@property`](http://www.phpdoc.org/docs/latest/references/phpdoc/tags/property.html) tag to your interface or concrete implementation, your IDE will be able to auto-complete the overloadable properties.
:::

## Behind the Scene

The [`Overload`](../properties/) component is responsible for handling the properties overloading of the `Dto` abstraction.
