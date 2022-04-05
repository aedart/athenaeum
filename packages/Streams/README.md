# Streams

The "streams" package offers an extended version of [PSR-7's](https://www.php-fig.org/psr/psr-7/#13-streams) defined `StreamInterface`;
a wrapper for common stream operations, mostly intended for file streams.

```php
use Aedart\Streams\FileStream;

$stream = FileStream::open('my-file.txt')
    ->put('Hi there');

$more = FileStream::openMemory()
    ->put("\nMore things to show...")
    ->positionToStart();

$stream
    ->append($more);

echo (string) $stream; // Hi there
                       // More things to show...
```

## Motivation

There are many good alternatives to this package. Sadly, some of those alternatives makes it unreasonably difficult to extend their offered functionality.
Therefore, while this package offers similar or identical functionality as some of those alternatives, it allows you (_and encourages you_) to extend the functionality that is provided by this package.

```php
use Aedart\Streams\FileStream;

class TranscriptFileStream extends FileStream
{
    // ...your domain-specific logic here ...
}
```

## Documentation

Please read the [official documentation](https://aedart.github.io/athenaeum/) for additional information.

## Repository

The mono repository is located at [github.com/aedart/athenaeum](https://github.com/aedart/athenaeum)

## Versioning

This package follows [Semantic Versioning 2.0.0](http://semver.org/)

## License

[BSD-3-Clause](http://spdx.org/licenses/BSD-3-Clause), Read the LICENSE file included in this package
