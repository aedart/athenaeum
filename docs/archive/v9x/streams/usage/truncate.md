---
description: How to truncate stream
sidebarDepth: 0
---

# Truncate

To truncate the stream to a specific size, use `truncate()`.

```php
$stream = FileStream::open('persons.txt', 'r')
    ->truncate(0);

echo $stream->getSize(); // 0
```

```php
$stream = FileStream::open('persons.txt', 'r')
    ->truncate(25);

echo $stream->getSize(); // 25
```

Behind the scene, [PHP's `ftruncate()`](https://www.php.net/manual/en/function.ftruncate) is used to truncate stream.
