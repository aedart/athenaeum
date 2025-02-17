---
description: About the Math Utility
sidebarDepth: 0
---

# Math

Offers math related utility methods.

[[TOC]]

## `randomizer()`

The `randomizer()` method returns a `NumericRandomizer` component - an adapter for PHP [`Random\Randomizer`](https://www.php.net/manual/en/class.random-randomizer.php).  

```php
$randomizer = Math::randomizer();
```

You can optionally specify what [`Engine`](https://www.php.net/manual/en/class.random-engine.php) you wish to use:

```php
use Aedart\Utils\Math;
use Random\Engine\Mt19937;

$randomizer = Math::randomizer(new Mt19937());
```

### `int()`

The `ìnt()` method returns a random number between provided `$min` and `$max`:

```php
echo Math::randomizer()->int(1, 10); // 7
```

_See [`Random\Randomizer::getInt()`](https://www.php.net/manual/en/random-randomizer.getint.php) for details._

### `nextInt()`

Returns the next positive integer.

```php
echo Math::randomizer()->nextInt(); // 4
```

_See [`Random\Randomizer::nextInt()`](https://www.php.net/manual/en/random-randomizer.nextint.php) for details._

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
