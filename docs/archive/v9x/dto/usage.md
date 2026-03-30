---
description: How to use DTO
---

# How to use

Once you have your implementation completed, simply create a new instance of your DTO.

```php
$person = new Person();
```

## Property overloading

If a getter and or setter method has been defined for a property, then it becomes accessible in multiple ways.

The following example illustrates how the `name` property can be set and retrieved, in multiple ways.

```php
// Name can be set using normal setter methods
$person->setName('John');

// But you can also just set the property itself
$person->name = 'Jack'; // Will automatically invoke setName()

// And you can also set it using an array-accessor
$person['name'] = 'Jane'; // Will also automatically invoke setName()

// ... //

// Obtain name using the regular getter method
$name = $person->getName();

// Can also get it via invoking the property directly
$name = $person->name; // Will automatically invoke getName()

// Lastly, it can also be access via an array-accessor
$name = $person['name']; // Also invokes the getName()
```

For additional information, please read about [Mutators and Accessor](https://en.wikipedia.org/wiki/Mutator_method), [PHP's overloading](http://php.net/manual/en/language.oop5.overloading.php),
and [PHP's Array-Access](http://php.net/manual/en/class.arrayaccess.php)

::: tip
By adding a [`@property`](http://www.phpdoc.org/docs/latest/references/phpdoc/tags/property.html) tag to your interface or concrete implementation, your IDE will should be able to auto-complete the overloadable properties.
:::

## Behind the Scene

The [`Overload`](../properties/) component is responsible most of the magic.
