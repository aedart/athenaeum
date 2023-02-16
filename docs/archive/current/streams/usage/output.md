---
description: Stream output utilities
sidebarDepth: 0
---

# Output

## Pass Through

The `passThrough()` outputs all remaining data from the stream.
PHP's [`fpassthru()`](https://www.php.net/manual/en/function.fpassthru) method is used for this purpose.

```php
$stream = FileStream::open('people.txt', 'r')
$stream->passThrough();
```
