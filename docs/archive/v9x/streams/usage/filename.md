---
description: Filename
sidebarDepth: 0
---

# Filename

There are two methods for obtaining the filename. The first is `uri()`, which return the `uri` [metadata](./meta.md).
The second is `filename()`, which returns the file's [basename](https://www.php.net/manual/en/function.basename), or a custom `filename` entry from the stream's metadata.

```php
$stream = FileStream::open('houses.txt', 'rb');

echo $stream->uri(); // /home/my_user/files/houses.txt
echo $stream->filename(); // houses.txt
```

If you specify a custom `filename` metadata, then it will be favoured instead of the basename.

```php
$stream = FileStream::open('houses.txt', 'rb');
$stream->meta()->set('filename', 'my_file.txt');

echo $stream->uri(); // /home/my_user/files/houses.txt
echo $stream->filename(); // my_file.txt
```