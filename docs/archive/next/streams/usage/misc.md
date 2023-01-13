---
description: Misc. stream utility methods
sidebarDepth: 0
---

# Misc

[[TOC]]

## Id

`id()` returns an integer id for the stream's underlying resource. See [`get_resource_id()`](https://www.php.net/manual/en/function.get-resource-id) for details. 

```php
$stream = FileStream::open('pets.txt', 'r');

echo $stream->id(); // 1330
```

## Mode

The stream's mode can be determined via the `mode()` method.

```php
$stream = FileStream::open('bills.txt', 'w+b');

echo $stream->mode(); // w+b
```

See [`stream_get_meta_data()`](https://www.php.net/manual/en/function.stream-get-meta-data) for details.

## Uri

The stream's filename or URI can be obtained using `uri()`. 

```php
$stream = FileStream::open('https://example.com/books', 'r+b');

echo $stream->uri(); // https://example.com/books
```

See [`stream_get_meta_data()`](https://www.php.net/manual/en/function.stream-get-meta-data) for details.

## Type

### Resource Type

To determine the type of the underlying resource, use the `type()` method.

```php
$stream = FileStream::open('pets.txt', 'r');

echo $stream->type(); // stream
```

See [`get_resource_type()`](https://www.php.net/manual/en/function.get-resource-type) for more information.

### Stream Type

To determine the stream type, use `streamType()`.

```php
$stream = FileStream::open('pets.txt', 'r');

echo $stream->streamType(); // STDIO
```

See [`stream_get_meta_data()`](https://www.php.net/manual/en/function.stream-get-meta-data) for details.

### Stream Wrapper Type

The stream's wrapper type can be determined via `wrapperType()`.

```php
$stream = FileStream::open('pets.txt', 'r');

echo $stream->wrapperType(); // plainfile
```

See [`stream_get_meta_data()`](https://www.php.net/manual/en/function.stream-get-meta-data) for details.

## Wrapper Data

`wrapperData()` can be used for obtaining stream wrapper's data.

```php
$stream = FileStream::open('https://www.google.com', 'r');

echo $stream->wrapperData(); // ...not shown here...
```

See [`stream_get_meta_data()`](https://www.php.net/manual/en/function.stream-get-meta-data) for details.

## Blocking Mode

To set the stream's blocking mode, use `setBlocking()`. Furthermore, use `blocked()` to determine if the stream is blocked.

```php
$stream = FileStream::open('houses.txt', 'r+b')
    ->setBlocking(true);

echo $stream->blocked(); // true
```

See [PHP's stream blocking mode](https://www.php.net/manual/en/function.stream-set-blocking.php) for additional information.

## Timeout

The `setTimeout()` can be used to set the stream's timeout, whereas the `timedOut()` can be used to determine if a stream has timed out.

It accepts two arguments:

* `int $seconds`: Seconds part of the timeout to be set.
* `int $microseconds`: (_optional_) microseconds part of the timeout to be set.

```php
$stream = FileStream::open('houses.txt', 'r+b')
    ->setTimeout(1, 50);

echo $stream->timedOut(); // false
```

See [`stream_set_timeout()`](https://www.php.net/manual/en/function.stream-set-timeout) for more information.

## Local or Remote

To determine if a stream is "local" or "remote", use the `isLocal()` and `isRemote()` methods.

```php
$a = FileStream::open('https://www.google.com', 'r');
$b = FileStream::open('books.txt', 'r');

echo $a->isLocal(); // false
echo $b->isLocal(); // true

echo $a->isRemote(); // true
echo $b->isRemote(); // false
```

PHP's [`stream_is_local()`](https://www.php.net/manual/en/function.stream-is-local.php) is used to determine if a stream is local or remote.

## Onward

For additional utility methods, please review the source code the provided stream components.
