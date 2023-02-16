---
description: About the Array Utility
sidebarDepth: 0
---

# Array

Extended version of Laravel's [`Arr` component](https://laravel.com/docs/9.x/helpers#arrays).

[[TOC]]

## `randomElement()`

Returns a single random element from a given list.

```php
use Aedart\Utils\Arr;

$element = Arr::randomElement(['Jim', 'Sine', 'Ally', 'Gordon']);
```

See also Laravel's [`Arr::random`](https://laravel.com/docs/9.x/helpers#method-array-random).

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