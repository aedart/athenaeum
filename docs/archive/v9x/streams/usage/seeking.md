---
description: How to seek stream
sidebarDepth: 0
---

# Seeking

[[TOC]]

## Determine if Seekable

The `isSeekable()` method can be used to determine if a stream is seekable or not.

```php
$a = FileStream::open('cities.txt', 'r+b');
$b = FileStream::make(fopen('php://output', 'r'));

echo $a->isSeekable(); // true
echo $b->isSeekable(); // false
```

## Position

The current read/write pointer position can be obtained via two methods:

```php
$position = $stream->tell();

// ...or via alias method

$position = $stream->position();
```

Both methods fail if unable to determine the pointer position (_`StreamException` is thrown, if such is the case_).

## Seek

### Via `seek()`

Use `seek()` to set the stream's read/write position.
The method accepts two arguments:

* `int $offset`: _streams offset_
* `int $whence`: _how the cursor position will be calculated based on the seek offset_

```php
$stream->seek(50, SEEK_SET);
```

For additional information, see [PHP's documentation](https://www.php.net/manual/en/function.fseek).

### Via `positionAt()`

The `positionAt()` method is a "fluent" version of the `seek()` method. After read/write pointer position has been set, a reference to the stream instance is returned.

```php{2}
$position = $stream
    ->positionAt(50, SEEK_SET)
    ->position();

echo $position; // 50
```

## Rewind

### Via `rewind()`

The `rewind()` method sets the read/write pointer position to `0` (_beginning of the file stream_).

```php
$stream->rewind();
```

### Via `positionToStart()`

The `positionToStart()` methods is a "fluent" version of `rewind()`.

```php{2}
$position = $stream
    ->positionToStart()
    ->position();

echo $position; // 0
```

### Rewind after operation

When you need to perform some kind of operation on a stream and rewind it afterwards, then you can use the `rewindAfter()` method.
It accepts a callback, which is executed and the position is thereafter rewound.  

The callback is given the stream reference as argument.

```php
$output = $stream
    ->rewindAfter(function($stream) {
        // ...do something with stream and return evt. output.
        
        return 'abc';
    });

echo $output; // abc
echo $stream->position(); // 0
```

## End

Use `positionToEnd()` to move pointer position to the end of the stream (_method is also "fluent"_).

```php
$stream->positionToEnd();
```

### Determine if EOF

To determine if position is at end-of-file (_EOF_), use the `eof()` method.

```php{3}
$atEnd = $stream
    ->positionToEnd()
    ->eof();

echo $atEnd; // true
```

## Restore Position

When you need to restore the current read/write pointer position, after you have performed some kind of operation, then you use the `restorePositionAfter()` method.

```php{3-5}
$output = $stream
    ->positionAt(50)
    ->restorePositionAfter(function($stream) {
        return (string) $stream;
    });

echo $output; // (stream's content)
echo $stream->position(); // 50 
```
