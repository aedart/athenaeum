---
description: About the String Utility
sidebarDepth: 0
---

# String

Extended version of Laravel's [`Str` component](https://laravel.com/docs/12.x/helpers#strings-method-list).

[[TOC]]

## `randomizer()`

The `randomizer()` method returns a `StringRandomizer` component - an adapter for PHP [`Random\Randomizer`](https://www.php.net/manual/en/class.random-randomizer.php).

```php
use Aedart\Utils\Str;

$randomizer = Str::randomizer();
```

You can optionally specify what [`Engine`](https://www.php.net/manual/en/class.random-engine.php) you wish to use:

```php
use Aedart\Utils\Str;
use Random\Engine\Mt19937;

$randomizer = Str::randomizer(new Mt19937());
```

### `bytes()`

Returns random bytes.

```php
Str::randomizer()->bytes(10); // \pǓY��n
```

_See [`Random\Randomizer::getBytes()`](https://www.php.net/manual/en/random-randomizer.getbytes.php) for details._

### `bytesFromString()`

Returns random bytes from a given string.

```php
$str = 'abcdefghijklmnopqrstuvwxyz0123456789';
Str::randomizer()->bytesFromString($str, 10); // hnm1vb3nu6
```

_See [`Random\Randomizer::getBytesFromString()`](https://www.php.net/manual/en/random-randomizer.getbytesfromstring.php) for details._

### `shuffle()`

Shuffles given bytes.

```php
$chars = implode('', range('a', 'z'));
Str::randomizer()->shuffle($chars); // lgtkrcvenbodmfzauxhqyiwjsp
```

_See [`Random\Randomizer::shuffleBytes()`](https://www.php.net/manual/en/random-randomizer.shufflebytes.php) for details._

## `slugToWords()`

Method converts a slug back to words.

```php
use Aedart\Utils\Str;

echo (string) Str::slugToWords('my-slug'); // My Slug
```
