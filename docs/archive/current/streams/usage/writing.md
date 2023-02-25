---
description: How to write to stream
sidebarDepth: 0
---

# Writing

[[TOC]]

## Determine if Writable

The `isWritable()` determines if a stream is writable or not.

```php
$a = FileStream::open('people.txt', 'r+b');
$b = FileStream::open('contacts.txt', 'rb');

echo $a->isWritable(); // true
echo $b->isWritable(); // false
```

## Write

Use the `write()` method to write data to the stream.

The method returns amount of bytes written to the stream.

```php
$stream = FileStream::openTemporary();
$bytes = $stream->write('abc');

echo $bytes; // 3
```

Behind the scene, [PHP's `fwrite()`](https://www.php.net/manual/en/function.fwrite.php) is used for writing data to the stream.

### Write Formatted

If you want to write data using a specific format, then you can use the `writeFormatted()` method.

The method accepts a `$format` argument, as specified by [PHP's `fprintf()`](https://www.php.net/manual/en/function.fprintf), and an arbitrary amount of values.

Similar to `write()`, this method also returns the amount of bytes written to the stream.

```php{6}
$stream = FileStream::openTemporary();

$greetings = 'Hi there';
$name = 'John';

$bytes = $stream->writeFormatted('%s <<%s>>', $greetings, $name);

echo $bytes; // 16
echo (string) $stream; // Hi there <<John>>
```

## Put

Alternatively, you can use the `put()` method to write data to a stream.
This method is a "fluent" version of `write()`.

```php
$stream = FileStream::openTemporary()
    ->put('a')
    ->put('b')
    ->put('c');

echo (string) $stream; // abc
```

### Put Formatted

`putFormatted()` is a "fluent" version of the `writeFormatted()` method.

```php{8-10}
$stream = FileStream::openTemporary();

$a = 'Hi there';
$b = 'John';
$c = 'Smith'

$stream
    ->putFormatted('%s ', $a)
    ->putFormatted('<<%s ', $b)
    ->putFormatted('%s>>', $c);

echo (string) $stream; // Hi there <<John Smith>>
```

## Append

The `append()` method is able to add data, at the end of the stream, if the stream is [seekable](./seeking.md#determine-if-seekable).
If the stream is not seekable, then a `StreamNotSeekable` exception will be thrown.

The method accepts four arguments:

* `$data`: Data to be appended.
* `int|null $length`: (_optional_) Maximum bytes to append. By default, all bytes left in `$data` are appended.
* `int $offset`: (_optional_) The offset where to start to copy data (_offset on `$data`_).
* `int|null $maximumMemory`: (_optional_) Maximum amount of bytes, before writing to a temporary file. (_Defaults to 2 MB if not specified_).

The `$maximumMemory` argument is relevant when `$data` is a pure string, or numeric.
If that is the case, then the `append()` method will wrap the `$data` into a ["temporary" stream](./open-close.md#temporary) internally, before reading from it. 

```php
$stream = FileStream::open('people.txt', 'r+b')
    ->append("\nJohn");
```

Behind the scene, [PHP's `stream_copy_to_stream()`](https://www.php.net/manual/en/function.stream-copy-to-stream.php) is used to append.

### Append Resource

To append data from a resource, pass in the resource as the `$data` argument.

```php
$resource = fopen('contacts.txt', 'r');

$stream = FileStream::open('people.txt', 'r+b')
    ->append($resource);
```

### Append Stream

You may also append directly from another stream.

```php
$from = FileStream::open('contacts.txt', 'r');

$stream = FileStream::open('people.txt', 'r+b')
    ->append($from);
```

::: warning Caution

**When pure PSR-7 `StreamInterface` is appended**

If you choose to append from pure "PSR stream" (_a stream that inherits from `StreamInterface`, but not from `\Aedart\Contracts\Streams\Stream`_), then the given "data" stream is automatically [detached](./open-close.md#detaching-resource). 

```php
$stream = FileStream::open('people.txt', 'r+b')
    ->append($psrStream);

// Attempt using "psr stream" after it was appended...
$psrStream->rewind(); // Invalid - Exception is thrown
```

The reason for this behavior is due to the limitation of [PSR-7's defined `StreamInterface`](https://www.php-fig.org/psr/psr-7/#34-psrhttpmessagestreaminterface).
There is no safe way to obtain a reference to the underlying resource, without detaching it.
PHP's native [`stream_copy_to_stream()`](https://www.php.net/manual/en/function.stream-copy-to-stream.php) can therefore not be applied.

**Workaround**

See [`copyFrom()`](#copy-from).

:::

## Copy

In situations when you wish to copy the stream, then you can use the `copy()` method.

This method will create a new "temporary" stream via [`openTemporary()`](./open-close.md#temporary).

It accepts optional `$length` and `$offset` as arguments.

```php
$stream = FileStream::open('my-file.txt', 'r+b')
    ->put('abc')
    ->positionToStart();

$copyA = $stream->copy();
$copyB = $stream
    ->positionToStart()
    ->copy(1, 1);

echo $copyA; // abc
echo $copyB; // b
```

::: tip Note
The initial stream's position is affected by the `copy()` method. 
:::

Behind the scene, [PHP's `stream_copy_to_stream()`](https://www.php.net/manual/en/function.stream-copy-to-stream.php) is used for the copy operation.

### Copy To Target

If you wish to copy a stream into a specific target stream, then use the `copyTo()` method.

It accepts a `$target` stream, `$length` and `$offset` as optional arguments.

```php{6}
$stream = FileStream::open('my-file.txt', 'r+b')
    ->put('abc')
    ->positionToStart();

$target = FileStream::open('target.txt', 'r+b');
$copy = $stream->copyTo($target, 1, 1);

echo ($copy === $target); // true
echo (string) $copy; // b
```

### Copy From

_**Available since** `v7.4.x`_

Alternatively, you may also copy data from an existing resource or stream.

```php
$target = FileStream::openMemory()
    ->copyFrom($existing);
```

Similar to the [`copyTo()`](#copy-to-target) method, this method accepts a `$source` stream, a `$length` and an `$offset` argument.

The `$source` argument accepts the following types:

* `resource`
* `\Aedart\Contracts\Streams\Stream`
* `\Psr\Http\Message\StreamInterface`

::: tip PSR-7 Stream

Unlike the [`copyTo()`](#copy) or [`append()`](#append) methods, this method will not [detach](./open-close.md#detaching-resource) the underlying resource of the source PSR-7 stream.

```php
$psrStream->rewind();
$target = FileStream::openMemory()
    ->copyFrom($psrStream);

$psrStream->rewind(); // valid - underlying resource is still attached
```

:::