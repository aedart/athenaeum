---
description: About the Math Utility
sidebarDepth: 0
---

# Math

Offers math related utility methods.

[[TOC]]

## `randomInt()`

Generates a random number between given minimum and maximum values.

```php
use Aedart\Utils\Math;

$value = Math::randomInt(1, 10);
```

## `seed()`

Generates a value that can be used for seeding the random number generator.

```php
use Aedart\Utils\Math;

$seed = Math::seed();

mt_srand($seed);
```

## `applySeed()`

A wrapper for [PHP's `mt_srand()`](https://www.php.net/manual/en/function.mt-srand) method, which seeds the Mersenne Twister Random Number Generator.

```php
use Aedart\Utils\Math;

$seed = 123456;
$list = ['a', 'b', 'c', 'd'];

Math::applySeed($seed);
$resultA = $list[ array_rand($list, 1) ];

Math::applySeed($seed);
$resultB = $list[ array_rand($list, 1) ];

echo $resultA; // b
echo $resultB; // b
```

### Seed mode

Use the 3rd argument to specify the seeding algorithm mode: 

```php
use Aedart\Utils\Math;

$seed = 123456;
$list = ['a', 'b', 'c', 'd'];

Math::applySeed($seed, MT_RAND_PHP);
$resultA = $list[ array_rand($list, 1) ];

// ...etc
```
