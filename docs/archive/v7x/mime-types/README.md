---
description: About the MIME-Types package
---

# MIME-Types

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

