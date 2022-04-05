---
description: How to flush stream
sidebarDepth: 0
---

# Flush

The `flush()` method can be used to write all buffered output to the open file.

```php
$stream = FileStream::open('persons.txt', 'r+b')
    ->put($data)
    ->flush();
```

[PHP's `fflush()`](https://www.php.net/manual/en/function.fflush) is used to perform the flush operation.
