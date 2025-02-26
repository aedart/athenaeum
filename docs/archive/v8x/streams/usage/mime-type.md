---
description: Determine MIME-Type of stream
sidebarDepth: 0
---

# MIME-Type

The `mimeType()` method can be used to determine the file stream's [MIME-Type](https://en.wikipedia.org/wiki/Media_type).

```php
$stream = FileStream::open('houses.txt', 'rb');

echo $stream->mimeType(); // text/plain
```

Behind the scene, the [MIME-Type Component](./../../mime-types) is used.

## Profile and Options

The method also allows you to specify what "profile" to use for determining the MIME-Type, as well as eventual options for the profile.

```php
$stream = FileStream::open('houses.txt', 'rb');

echo $stream->mimeType('mime-detector-profile', [
    'sample_size' => 50
]); // text/plain
```

Please see [MIME-Type usage](./../../mime-types/usage.md) for additional details.
