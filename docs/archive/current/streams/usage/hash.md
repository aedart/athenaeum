---
description: Hash of stream
sidebarDepth: 0
---

# Hash

If you need to obtain a hash of the stream's content, then use the `hash()` method.

The method accepts a number of arguments;

* `string $algo`: Name of the hashing algorithm to be used.
* `bool $binary`: (_optional_) If `true`, outputs raw binary data.
* `int $flags`: (_optional_) Optional settings for hash generation
* `string $key`: (_optional_) Shared secret key, when `HASH_HMAC` specified in `$flags`
* `array $options`: (_optional_) Options for the specified hashing algorithm

```php
$stream = FileStream::open('persons.txt', 'rb');

echo $stream->hash('crc32'); // d5aad468
```

For additional information, please review PHP documentation:

* [`hash_init()`](https://www.php.net/manual/en/function.hash-init.php)
* [`hash_update_stream()`](https://www.php.net/manual/en/function.hash-update-stream.php)
* [`hash_final()`](https://www.php.net/manual/en/function.hash-final.php)
