---
description: About the Array Utility
sidebarDepth: 0
---

# Array

Extended version of Laravel's [`Arr` component](https://laravel.com/docs/11.x/helpers#arrays).

[[TOC]]

## `randomElement()`

::: danger Deprecated
The `randomElement()` is deprecated. Pleas use [`Arr::randomizer()->value()`](#value) instead.
:::


Returns a single random element from a given list.

```php
use Aedart\Utils\Arr;

$element = Arr::randomElement(['Jim', 'Sine', 'Ally', 'Gordon']);
```

See also Laravel's [`Arr::random`](https://laravel.com/docs/11.x/helpers#method-array-random).

### Seeding

You can also provide a [seed for the random number generator](https://www.php.net/manual/en/function.mt-srand.php). 

```php
use Aedart\Utils\Arr;
use Aedart\Utils\Math;

$element = Arr::randomElement(
    ['Jim', 'Sine', 'Ally', 'Gordon'],
    Math::seed(),
    MT_RAND_PHP
);
```

See [`Math::seed()` and `Math::applySeed()` methods ](math.md) for additional information about seeding.

## `randomizer()`

The `randomizer()` method returns a `ArrayRandomizer` component - an adapter for PHP [`Random\Randomizer`](https://www.php.net/manual/en/class.random-randomizer.php).

```php
use Aedart\Utils\Arr;

$randomizer = Arr::randomizer();
```

You can optionally specify what [`Engine`](https://www.php.net/manual/en/class.random-engine.php) you wish to use:

```php
use Aedart\Utils\Arr;
use Random\Engine\Mt19937;

$randomizer = Arr::randomizer(new Mt19937());
```

### `pickKey()`

Returns a single random key.

```php
$arr = [ 'a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5 ];

Arr::randomizer()->pickKey($arr); // c
```

### `pickKeys()`

Returns random array keys.

```php
$arr = [ 'a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5 ];

Arr::randomizer()->pickKeys($arr, 2); // [ 'b', 'd' ]
```

_See [`Random\Randomizer::pickArrayKeys()`](https://www.php.net/manual/en/random-randomizer.pickarraykeys.php) for details._

### `value()`

Returns a random entry (value) from array.

```php
$arr = [ 'a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5 ];

Arr::randomizer()->value($arr); // 4
```

### `values()`

Returns random entries (values) from array.

```php
$arr = [ 'a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5 ];

Arr::randomizer()->values($arr, 2); // [ 2, 5 ]
```

You can pass `true` as the third argument, if you wish to preserve the keys.

```php
$arr = [ 'a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5 ];

Arr::randomizer()->values($arr, 2, true); // [ 'b' => 2, 'e' => 5 ]
``` 

### `shuffle()`

Shuffles given array.

```php
$arr = [ 'a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5 ];

Arr::randomizer()->shuffle($arr); // [ 2, 1, 4, 3, 5 ]
```

::: warning Caution
`shuffle()` does NOT preserve the array keys.
:::

_See [`Random\Randomizer::shuffleArray()`](https://www.php.net/manual/en/random-randomizer.shufflearray.php) for details._

## `differenceAssoc()`

Method computes the difference of two or more multidimensional arrays.

```php
use Aedart\Utils\Arr;

$original = [
    'key' => 'person',
    'value' => 'John Snow',
    'settings' => [
        'validation' => [
            'required' => true,
            'nullable' => true,
            'min' => 2,
            'max' => 50,
        ]
    ]
];

$changed = [
    'key' => 'person',
    'value' => 'Smith Snow', // Changed
    'settings' => [
        'validation' => [
            'required' => false, // Changed
            'nullable' => true,
            'min' => 2,
            'max' => 100, // Changed
        ]
    ]
];

$result = Arr::differenceAssoc($original, $changed);
print_r($result);
```

The output of the above shown example will be the following:

```
Array
(
  ['value'] => 'John Snow'
  ['settings'] => Array
      (
          ['validation'] => Array
              (
                  ['required'] => 1
                  ['max'] => 50
              )
      )
)
```

## `tree()`

Returns an array that represents a "tree" structure for given path.

```php
use Aedart\Utils\Arr;

$result = Arr::tree('/home/user/projects');

print_r($result);
```

```
Array
(
    [0] => /home
    [1] => /home/user
    [2] => /home/user/projects
)
```