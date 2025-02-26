---
description: Summation Collection
sidebarDepth: 0
---

# Summation Collection

A collection of numeric values, which are typically a product of processing multiple items, e.g. database records.
Most commonly, you would use this component in combination with an [Items Processor](./items-processor.md).

Within this context, the term "summation" is referred to as a _"[...] cumulative action or effect [...]"_ ([Merriam Webster](https://www.merriam-webster.com/dictionary/summation)). 

[[TOC]]

## Basic Example

```php
use Aedart\Collections\Summation;

$collection = Summation::make([
    'points' => 0
]);

$result = $collection
    ->increase('points', 5)
    ->decrease('points', 1)
    ->get('points');

echo $result; // 4
```

## Setting initial values

To work with a `Summation` collection, you must first set the initial value(s), which you later wish to process in some way.
You can either state them when you create a new instance (_e.g. via the `make()` method_), or by using the `set()` method.

```php
$collection = Summation::make([
    'strength' => 15,
    'agility' => 22,
    'intelligence' => 19,
]);

// Or...

$collection = Summation::make()
    ->set('strength', 15)
    ->set('agility', 22)
    ->set('intelligence', 19);
```

## Processing values

### Increase

Use the `increase()` or `add()` method to increase a key's value with a given amount.

```php
$result = Summation::make()
    ->set('points', 0)
    
    ->increase('points', 5)
    ->add('points', 1)
    
    ->get('points');

echo $result; // 6
```

### Decrease

To decrease a key's value, you can use the `decrease()` or `subtract()` method.

```php
$result = Summation::make()
    ->set('points', 25)
    
    ->decrease('points', 5)
    ->subtract('points', 1)
    
    ->get('points');

echo $result; // 19
```

### Multiply

You can multiple an existing key's value using the `multiply()` method.

```php
$result = Summation::make()
    ->set('points', 5)
    
    ->multiply('points', 5)
    
    ->get('points');

echo $result; // 25
```

### Divide

To divide and existing key's value, use the `divide()` method.

```php
$result = Summation::make()
    ->set('points', 25)
    
    ->divide('points', 3)
    
    ->get('points');

echo $result; // 8.3333
```

### Apply Callback

All processing methods accept a `callable` as a value, in which you can process a given key's value, however you want.
The result of the given callback is the used as the key's new value. 

```php
$result = Summation::make()
    ->set('points', 25)
    ->set('amount', 8)
    
    ->set('points', function($value, Summation $summation) {
        return $value / $summation->get('amount');
    })
    
    ->get('points');

echo $result; // 3.125
```

## Dot notation

Laravel's "dot notation" is also supported by the `Summation` collection component.

```php
$result = Summation::make()
    ->set('player.strength', 16)
    
    ->increase('player.strength', 2)
    
    ->get('player.strength');

echo $result; // 18
```

## Determine keys and values

### Has key

The `has()` method can be used to determine whether a key exists in the collection or not.

```php
$collection->has('score'); // true or false
```

::: tip Note
The `has()` will return `true` if a key exists, even if the key's value is zero (_empty_). 
:::

### Has value

To determine if a key exists and has a value (_nonempty value_), use the `hasValue()` method.

```php
$collection->hasValue('score'); // true if key exists and has a nonempty value
```

## Removing keys

A key and it's associated value can be deleted by using the `remove()` method.

```php
$collection->remove('player.intelligence');
```

## Exporting

### To Array

The `toArray()` method will export all keys and values to a native php `array`.

```php
$arr = $collection->toArray();
```

### To Json

If you wish to retrieve a Json representation of the collection, you can either use the `toJson()` method or invoke `json_encode()` directly on the collection. 

```php
$result = $collection->toJson();

// Or...

$result = json_encode($collection);
```

## Debugging

::: warning Prerequisite
To use the debugging methods, you must have [`symfony/var-dumper`](https://packagist.org/packages/symfony/var-dumper) installed.
:::


The `dd()` method will dump the collection's keys and values and stop further script execution.

```php
$collection->dd(); // Dumps keys and values and STOPS script execution!
```

The `dump()` method, on the other hand, will only dump the collection's keys and values.

```php
$result = $collection
    ->set('points', 5)
    ->increase('points', 1)
    ->dump() // Dumps keys and values
    ->decrease('points', 2)
    ->get('points');

echo $result; // 4
```
