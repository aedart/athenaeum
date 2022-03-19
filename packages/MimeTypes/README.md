# Athenaeum Mime-Types

A "profile" based [MIME-type](https://en.wikipedia.org/wiki/Media_type) detector, which uses a string or a `resource` as sample.

```php
use Aedart\MimeTypes\Detector;

$file = fopen('my-picture.jpg', 'rb');

// Detect mime-type by only reading xx-bytes from file...
$mimeType = (new Detector())->detect($file);
fclose($file);

print_r($mimeType);
```

Output example:

```
Aedart\MimeTypes\MimeType Object
(
    [description] => JPEG image data, JFIF standard 1.01, resolution (DPI),...
    [mime] => image/jpeg; charset=binary
    [type] => image/jpeg
    [encoding] => binary
    [known_extensions] => Array
        (
            [0] => jpeg
            [1] => jpg
            [2] => jpe
            [3] => jfif
        )
)
```

Behind the scene, the default profile driver uses PHP's [File Info Extension](https://www.php.net/manual/en/book.fileinfo.php).

## Documentation

Please read the [official documentation](https://aedart.github.io/athenaeum/) for additional information.

## Repository

The mono repository is located at [github.com/aedart/athenaeum](https://github.com/aedart/athenaeum)

## Versioning

This package follows [Semantic Versioning 2.0.0](http://semver.org/)

## License

[BSD-3-Clause](http://spdx.org/licenses/BSD-3-Clause), Read the LICENSE file included in this package
