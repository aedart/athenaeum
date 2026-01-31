---
description: How to sync stream
sidebarDepth: 0
---

# Sync

Invoking the `sync()` method will synchronise changes to a file.

```php
$writeStream = FileStream::open('persons.txt', 'w');

// Add data and sync to file...
$writeStream
    ->put('John Snow')
    ->sync();

// Add more data, but do not synchronise
$writeStream
    ->put('Jane Doe');

// ----------------------------------------------------------- //
// Elsewhere in your application, when you read the stream
$readStream = FileStream::open('persons.txt', 'r');
$result = $readStream->getContents();

// Only first data was synchronised to the file...
echo $result; // John Snow
```

You can also set the `$withoutMeta` argument to `true`, if you only want meta-data to be synchronised.

See PHP's [`fsync`](https://www.php.net/manual/en/function.fsync) and [`fdatasync`](https://www.php.net/manual/en/function.fdatasync) for more information.
