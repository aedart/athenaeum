---
description: How to read from stream
sidebarDepth: 0
---

# Reading

[[TOC]]

## Determine if Readable

The `isReadable()` determines if a stream is readable or not.

```php
$a = FileStream::open('people.txt', 'rb');
$b = FileStream::open('contacts.txt', 'a');

echo $a->isReadable(); // true
echo $b->isReadable(); // false
```

## Read

The `read()` returns up to the specified amount of bytes requested read. Fewer bytes may be returned, if underlying resource does not contain the amount of bytes requested.

```php
$data = $stream->read(50); // 50 bytes of data
```

### Remaining Content

To obtain the remaining contents of a stream, use the `getContents()`.

```php{3}
$data = $stream
    ->positionAt(50)
    ->getContents();
```

### All Contents

If you wish to obtain the entire contents of a stream, then you can do so by either casting the stream to a `string` or manually invoking the `__toString()`.

```php
$data = (string) $stream; // All contents of stream
```

::: tip Info
The stream's read/write position is automatically set to `0` (_the beginning of the stream_), before the content is returned when cast to a string.
:::

## Read Characters

### Single Character

The `readCharacter()` method is useful when you wish to read a single character from a stream.

```php{9-11}
// Given the following...
$resource = fopen('php://memory', 'r+b');
fwrite($resource, 'abc');

$stream = FileStream::make($resource)
    ->positionToStart();

// Read a character...
$a = $stream->readCharacter();
$b = $stream->readCharacter();
$c = $stream->readCharacter();

echo $a; // a
echo $b; // b
echo $c; // c
```

Behind the scene, [PHP's `fgetc()`](https://www.php.net/manual/en/function.fgetc) is used.

### All Characters

`readAllCharacters()` returns an [`iterable`](https://www.php.net/manual/en/language.types.iterable.php) generator which allows you to iterator throughout all the stream's characters.

```php{10}
// Given the following...
$resource = fopen('php://memory', 'r+b');
fwrite($resource, 'abc');

$stream = FileStream::make($resource);

// Read all characters...
$buffer = '';
$characters = $stream->readAllCharacters();
foreach ($characters as $character) {
    $buffer .= $character;
}

echo $buffer; // abc
```

::: tip Note
_This method automatically rewinds the stream. See [`readCharacter()`](#single-character) as an alternative method._
:::

## Read Lines

### Single Line

You can use the `readLine()` method to read a single line of content from the stream.

```php{9-11}
// Given the following...
$resource = fopen('php://memory', 'r+b');
fwrite($resource, "a\nb\nc\n");

$stream = FileStream::make($resource)
    ->positionToStart();

// Read a line...
$a = $stream->readLine();
$b = $stream->readLine();
$c = $stream->readLine();

echo trim($a); // a
echo trim($b); // b
echo trim($c); // c
```

Behind the scene, [PHP's `fgets()`](https://www.php.net/manual/en/function.fgets) is used.

::: tip Note
The `readLine()` also includes newline character in its output.
:::

#### Length

The `readLine()` method also accepts optional `$length` argument.
When length is specified, reading stops when either of these conditions are met.

* Length - 1 byte (_length minus 1 byte_) has been reached
* Newline character is reached (_included in output_)
* EOF is reached.

```php{9}
// Given the following...
$resource = fopen('php://memory', 'r+b');
fwrite($resource, "aaa\nbbb\nccc\n");

$stream = FileStream::make($resource)
    ->positionToStart();

// Read length...
echo $stream->readLine(3); // aa (length minus 1 byte)
```

### Single Line Until

Use the `readLineUntil()` method to read a line until a specified length and or delimiter is reached.
This method stops reading when either of the these conditions are met:

* Length - 1 byte (_length minus 1 byte_) has been reached
* Delimiter character is reached (_NOT included in output_)
* EOF is reached.

```php{12-14}
// Given the following...
$resource = fopen('php://memory', 'r+b');
fwrite($resource, "a;b;c;");

$stream = FileStream::make($resource)
    ->positionToStart();

$length = 5;
$delimiter = ';'

// Read until length/delimiter
$a = $stream->readLineUntil($length, $delimiter);
$b = $stream->readLineUntil($length, $delimiter);
$c = $stream->readLineUntil($length, $delimiter);

echo $a; // a
echo $b; // b
echo $c; // c
```

### All Lines

If you need to read all lines from a stream, then use the `readAllLines()` method.
It returns an [`iterable`](https://www.php.net/manual/en/language.types.iterable.php) generator.

```php{10}
// Given the following...
$resource = fopen('php://memory', 'r+b');
fwrite($resource, "a\nb\nc\n");

$stream = FileStream::make($resource);

// Read all lines...
$buffer = '';
$lines = $stream->readAllLines();
foreach ($lines as $line) {
    $buffer .= $line;
}

echo $buffer; // abc
```

::: tip Note
_This method automatically rewinds the stream. See [`readLine()`](#single-line) as an alternative method._
:::

::: tip Automatic Trim
Unlike the `readLine()` method, `readAllLines()` automatically trims all lines before returning.
This means that newline character is NOT included in the output.
:::

#### Alternative way to read all lines

The `Stream` and `FileStream` components inherit from the [`IteratorAggregate`](https://www.php.net/manual/en/class.iteratoraggregate) and can therefore be iterated directly.
When doing so, it is the equivalent of invoking the `readAllLines()` method.

```php
// Iterate through stream's lines
foreach ($stream as $line) {
    // ...Do something with line...
}
```

### All Lines (Using delimiter)

You can also iterate though all lines using the `readAllUsingDelimiter`. It behaves similar to the `readLineUntil()` method. 
In the following example, each line is returned when either of these conditions are met:

* Length - 1 byte (_length minus 1 byte_) has been reached
* Delimiter character is reached (_NOT included in output_)
* EOF is reached.

```php{10}
// Given the following...
$resource = fopen('php://memory', 'r+b');
fwrite($resource, "aa||bb||cc");

$stream = FileStream::make($resource);

// Read all lines using a length / delimiter
$buffer = '';
$iterator = $stream->readAllUsingDelimiter(10, '||');
foreach ($iterator as $line) {
    $buffer .= $line;
}

echo $buffer; // aabbcc
```

::: tip Note
_This method automatically rewinds the stream. See [`readLineUntil()`](#single-line-until) as an alternative method._
:::

## Scan Format

To scan the stream's content according to a format, use the `scan()` method.
It accepts a `$format` as specified by [PHP's `fscanf()`](https://www.php.net/manual/en/function.fscanf).

```php{10}
// Given the following...
$resource = fopen('php://memory', 'r+b');
fwrite($resource, "aa-\nbb-\ncc-\n");

$stream = FileStream::make($resource)
    ->positionToStart();

// Scan according to format
$buffer = '';
while ($scanned = $stream->scan('%s-')) {
    $buffer .= $scanned[0];
}

echo $buffer; // aa-bb-cc-
```

::: tip Note
If the stream you are processing is of considerable size, and you need to scan the entire content, then you should use the `readAllUsingFormat()` instead of `scan()`.
:::

### Scan All

Use `readAllUsingFormat()` to scan entire stream's content according to specified format.

```php{10}
// Given the following...
$resource = fopen('php://memory', 'r+b');
fwrite($resource, "aa||\nbb||\ncc||\n");

$stream = FileStream::make($resource);

// Scan according to format
$buffer = '';
$all = $stream->readAllUsingFormat('%s||');
foreach ($all as $scanned) {
    $buffer .= $scanned[0];
}

echo $buffer; // aa||bb||cc||
```

::: tip Note
_This method automatically rewinds the stream. See [`scan()`](#scan-format) as an alternative method._
:::

## Read Chunks

You can also read a stream's content in chunks of a specified size.
The `readAllInChunks()` method accepts an optional `$size` argument, which determine the amount of bytes to be read per "chunk".

```php{10}
// Given the following...
$resource = fopen('php://memory', 'r+b');
fwrite($resource, "abc");

$stream = FileStream::make($resource)
    ->positionToStart();

// Read all in chunks of 1 byte
$buffer = '';
$chunks = $stream->readAllInChunks(1);
foreach ($chunks as $chunk) {
    $buffer .= $chunk;
}

echo $buffer; // abc
```

::: tip Note
_This method automatically rewinds the stream. See [`buffer()`](#buffer) as an alternative method._
:::

## Read All using Callback

Lastly, if none of the default offered "read all" methods are to your liking, then you can use `readAllUsing()` method to specify a custom callback for how to read the stream's underlying resource.
The method returns an [`iterable`](https://www.php.net/manual/en/language.types.iterable.php) generator, just like the other "read-all" methods.

The given callback will receive the stream's underlying `resource` as argument.

_The following example corresponds to the same result as invoking the `readAllInChunks()` method._

```php{9-11}
// Given the following...
$resource = fopen('php://memory', 'r+b');
fwrite($resource, "aabbcc");

$stream = FileStream::make($resource);

// Read all using custom callback
$buffer = '';
$chunks = $stream->readAllUsing(function($resource) {
    return fread($resource, 2);
});

foreach ($chunks as $chunk) {
    $buffer .= $chunk;
}

echo $buffer; // aabbcc
```

::: tip Note
_This method automatically rewinds the stream. See [`buffer()`](#buffer) as an alternative method._
:::

## Buffer

_**Available since** `v7.4.x`_

To read the stream in chunks, using a specific buffer size, use the `buffer()` method.
It accepts the following arguments:

* `int|null $length = null`: (_optional_) Maximum bytes to read from stream. By default, all bytes left are read.
* `int $offset = 0`: (_optional_) The offset on where to start to reading from.
* `int $bufferSize = BufferSizes::BUFFER_8KB`: (_optional_) Read buffer size of each chunk in bytes.

```php
$iterator = $stream->buffer(
    length: 250,
    offset: 22,
    bufferSize: 50
);

foreach ($iterator as $chunk) {
    echo $chunk;
}
```