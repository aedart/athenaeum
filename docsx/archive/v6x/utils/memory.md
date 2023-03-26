---
description: About the Memory Utility
sidebarDepth: 0
---

# Memory

A memory utility that is able to convert between various order of magnitude.
It uses [bytes](https://en.wikipedia.org/wiki/Byte) as its lowest value and offers support upto [Exabyte or Exbibyte](https://en.wikipedia.org/wiki/Byte#Multiple-byte_units). 
In addition, it is also able to format a size to a "human-readable".

[SI](https://en.wikipedia.org/wiki/International_System_of_Units) "decimal" and "binary" values are supported.

**Example**

```php
use Aedart\Utils\Memory;

$bytes = 5_300_000_000;

echo Memory::unit($bytes)->binaryFormat(); // 4.9 GiB
echo Memory::unit($bytes)->decimalFormat(); // 5.3 GB
```

[[TOC]]

## Create

### From Bytes

To create a new memory unit instance from bytes, use the static `unit()` method.

```php
$bytes = 2_000_000;
$unit = Memory::unit($bytes);
```

### From String

You can also create a new instance from a string.

```php
$unit = Memory::from('1.48 kb');

echo $unit->bytes(); // 1480
```

The accepted format has to match the following:

```txt
format = value space unit;
value = INT | FLOAT;
space = "" | " "; // optional whitespace character
unit = (unit symbol or name);
```

Given the above shown format, the following strings can all be parsed into a value unit.

```php
$a = Memory::from('28 b');
$b = Memory::from('1.48 kb');
$c = Memory::from('3 megabyte');
$d = Memory::from('2 MiB');
$e = Memory::from('1.1gigabyte');
$f = Memory::from('5 terabytes');
$g = Memory::from('2.35 PB');
// ...etc
```

### From Other Values

Lastly, you can also create a unit instance from other units than bytes.

```php
$a = Memory::fromKibibyte(1540);
$b = Memory::fromMegabyte(2.4);
$c = Memory::fromGibibyte(1.33)
// ...etc
```

## Convert

The memory unit offers various conversion methods.

```php
use Aedart\Utils\Memory;

$gibibyte = Memory::fromGibibyte(1.33);

echo $gibibyte->toMegabyte(); // 1428.1
echo $gibibyte->toLegacyMegabyte(); // 1361.9
// ...etc
```

## Formatting

To format a unit to a "human-readable" string, you can use either of the following methods:

```php
$unit->binaryFormat();
$unit->decimalFormat();
$unit->legacyFormat() // binary using legacy metric name
$unit->format(); // Defaults to "binary"
```

See [wiki](https://en.wikipedia.org/wiki/Byte#Multiple-byte_units), and source code for details.

## Onward

Please review the source code of `Aedart\Utils\Memory` and `Aedart\Utils\Memory\Unit` for additional information.
