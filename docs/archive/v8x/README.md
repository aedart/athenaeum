---
description: Athenaeum Release Notes
sidebarDepth: 0
---

# Release Notes

[[toc]]

## Support Policy

Athenaeum attempts to follow a release cycle that matches closely to that of [Laravel](https://laravel.com/docs/11.x/releases).
However, due to limited amount of project maintainers, no guarantees can be provided. 

| Version | PHP         | Laravel | Release              | Security Fixes Until |
|---------|-------------|---------|----------------------|----------------------|
| `9.x`   | `8.3 - ?`   | `v12.x` | _~1st Quarter 2025_  | _TBD_                |
| `8.x`*  | `8.2 - 8.3` | `v11.x` | March 18th, 2024     | February 2025        |
| `7.x`   | `8.1 - 8.2` | `v10.x` | February 16th, 2023  | March 2024           |
| `6.x`   | `8.0 - 8.1` | `v9.x`  | April 5th, 2022      | February 2023        |
| `< 6.x` | _-_         | _-_     | _See `CHANGELOG.md`_ | _N/A_                |

_*: current supported version._

_TBD: "To be decided"._

## `v8.x` Highlights

These are the highlights of the latest major version of Athenaeum.

### PHP `v8.2` and Laravel `v11.x`

PHP version `v8.2` is now the minimum required version for Athenaeum.
[Laravel `v10.x`](https://laravel.com/docs/11.x/releases) packages are now used.

### Randomizers

`Math`, `Str` and `Arr` now offer a `randomizer()` method that returns an adapter for PHP's [`Random\Randomizer`](https://www.php.net/manual/en/class.random-randomizer.php).

```php
use Aedart\Utils\Arr;

$arr = [ 'a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5 ];

Arr::randomizer()->values($arr, 2); // [ 5, 2 ]
```

See [`Math::randomizer()`](./utils/math.md#randomizer), [`Str::randomizer()`](./utils/string.md#randomizer) and [`Arr::randomizer()`](./utils/array.md#randomizer) for additional information.

### Memory Snapshot

The [`Memory::snapshot()`](./utils/memory.md#snapshot) method returns the current memory usage.

```php
use Aedart\Utils\Memory;

$snapshot = Memory::snapshot();

echo $snapshot->bytes(); // 544812
```

## Changelog

Make sure to read the [changelog](https://github.com/aedart/athenaeum/blob/master/CHANGELOG.md) for additional information about the latest release, new features, changes and bug fixes. 
