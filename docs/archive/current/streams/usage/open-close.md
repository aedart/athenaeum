---
description: How to open and close a stream
sidebarDepth: 0
---

# Open and Close

[[TOC]]

## How to open

### File

Use the `open()` method to open a stream to a file or URL.

```php
use Aedart\Streams\FileStream;

$stream = FileStream::open('recipients.txt', 'r+b');
```

Behind the scene, PHP's [`fopen()`](https://www.php.net/manual/en/function.fopen) is used.

### Memory

To open a stream to `php://memory`, use the `openMemory()` method.

```php
$stream = FileStream::openMemory();
```

See [PHP Documentation](https://www.php.net/manual/en/wrappers.php.php#wrappers.php.memory) for additional details.

### Temporary

You may also open a stream to `php://temp`, by using `openTemporary()`

```php
$stream = FileStream::openTemporary();
```

To specify the maximum memory limit, before PHP's internal mechanisms write to a physical file, use the 2nd argument. 

```php
$stream = FileStream::openTemporary('r+b', 5 * 1024 * 1024);
```

See [PHP Documentation](https://www.php.net/manual/en/wrappers.php.php#wrappers.php.memory) for additional details.

### Existing resource

If you already have an existing `resource` to a file or URL, you can "wrap" it into a stream component, by using the `make()` method.

```php
$resource = fopen('team.txt', 'w+b');

// ...Later in your application...
$stream = Stream::make($resource);
```

### Existing PSR-Stream

Use the `makeFrom()` method when you need to wrap an existing `StreamInterface` component. 

```php
$stream = Stream::makeFrom($psrStream);
```

::: warning
The `makeFrom()` will automatically detach the given `StreamInterface` component's underlying `resource`.
This means that you will no longer be able to use the provided PSR stream instance.
:::

### SplFileInfo

_**Available since** `v7.4.x`_

When working with uploaded files, e.g. from Laravel or Symfony (_[`SplFileInfo` instances](https://www.php.net/manual/en/class.splfileinfo.php)_), then you can open a file stream using the `openFileInfo()` method.

```php
$stream = FileStream::openFileInfo($uploadedFile, 'r');
```

::: tip Filename
For Laravel and Symfony, the uploaded file's `getClientOriginalName()` return value is used as the stream's [`filename()` value](./filename.md).
:::

### PSR Uploaded File

_**Available since** `v7.4.x`_

You may also create a file stream instance for an existing [PSR-7 Uploaded File](https://www.php-fig.org/psr/psr-7/#36-psrhttpmessageuploadedfileinterface) instance, using the `openUploadedFile()` method.

```php
$stream = FileStream::openUploadedFile($psrUploadedFile);
```

::: warning
Unless specified otherwise, the `openUploadedFile()` method will automatically detach the uploaded file's underlying stream.
If you wish to avoid this, then set the `$asCopy` argument to true (_defaults to false_).

```php
// Copies the PSR stream into the file stream...
$stream = FileStream::openUploadedFile(
    file: $psrUploadedFile,
    asCopy: true
);
```

For more information, see the source code of `openUploadedFile()` and see also [copy from documentation](./writing.md#copy-from).
:::

::: tip Filename
The uploaded file's `getClientFilename()` return value is used as the stream's [`filename()` value](./filename.md).
:::

### Lazy

Lastly, you may also open a stream after you have created a `Stream` or `FileStream`, using a callback.
The `openUsing()` accepts a callback, which must return a valid `resource` of the type "stream".

```php
use Aedart\Streams\FileStream;

$stream = new FileStream();

// ...later in your application...
$stream->openUsing(function() {
    return fopen('countries.txt', 'rb');
});
```

::: tip Info

`openUsing()` will fail if the stream instance already has a valid `resource` specified (_when the stream is already open_).
Use the `isOpen()` method to determine if a stream can be opened.

```php
if (!$stream->isOpen()) {
    $stream->openUsing(function() {
        return fopen('countries.txt', 'rb');
    });
} else {
    // ...do something else...
}
```
:::

### Cloning

::: warning Not supported

Cloning an existing stream instance is not supported and will result in `StreamException` to be thrown.

```php
$stream = FileStream::open('locations.txt', 'r');
$clone = clone $stream; // Fails - StreamException is thrown!
```

:::

## How to close

### Close stream

When you need to close a stream, invoke the `close()` method.
The underlying `resource` will be detached and closed using PHP's [`fclose()`](https://www.php.net/manual/en/function.fclose).

```php
$stream->close();
```

### Detaching resource

If you do not wish to close the stream, but you want to detach - to separate the underlying `resource`, from the stream instance, then you can use the `detach()` method.

```php
$resource = $stream->detach();

// ...stream instance is now useless!
```

::: warning Caution
When you detach the underlying `resource` from the stream, the stream instance becomes useless.
You SHOULD avoid reusing or reopening a `resource`, when such is the case.

**Not recommended**

The following example is NOT recommended (_even though it is possible_)!

```php
$resource = $stream->detach();

// ...later... attempt to re-open using same resource
// and same stream instance - NOT RECOMMENDED!
$stream->openUsing(fn () => $resource);
```

Future versions of `Stream` and `FileStream` may prohibit this behaviour. 

:::
