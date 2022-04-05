---
description: Determine size of stream
sidebarDepth: 0
---

# Size

The `Stream` components offer a few ways to determine the size of the underlying resource.

[[TOC]]

## Raw size

Use `getSize()` to obtain the stream's size in bytes.
The method returns `null` if the size is not known or cannot be determined.

```php
// E.g. open file that 128 bytes in size
$stream = FileStream::open('persons.txt', 'r');

echo $stream->getSize(); // 128
```

## Count

The `Stream` components inherit from [PHP's `Countable` interface](https://www.php.net/manual/en/class.countable). This allows you to use `count()` directly on the stream.

```php
// E.g. open file that 51 bytes in size
$stream = FileStream::open('places.txt', 'r');

echo count($stream); // 51
```

## Formatted Size

Use `getFormattedSize()` if you wish to obtain a "human-readable" size of the stream.

_The method returns a formatted string._

```php
// E.g. open a "large" file...
$stream = FileStream::open('fx_lightning.mp4', 'r');

echo $stream->getFormattedSize(); // 4.3 MB
```
