---
description: How to use Mime-Types Detector
---

# Usage

[[TOC]]

## Detect MIME-Type

The following illustrates a few ways that you can use the `Detector` component to detect the MIME-type of a file. 

### Via stream

```php
$file = fopen('my-picture.jpg', 'rb');

$mimeType = (new Detector())->detect($file);
echo (string) $mimeType; // image/jpeg
```

### Via string

```php
$content = file_get_contents('my-picture.jpg');

$mimeType = (new Detector())->detect($content);
echo (string) $mimeType; // image/jpeg
```

### Via path

```php
$path = 'my-picture.jpg';

$mimeType = (new Detector())->detectForFile($path);
echo (string) $mimeType; // image/jpeg
```

### Using a different profile

If you have multiple "profiles", you can choose to specify what profile to use for the detection.
This is applicable for both the `detect()` and `detectForFile()` method.

```php
// Specify profile as 2nd argument
$mimeType = (new Detector())->detect($file, 'my-profile');

// Or...
$mimeType = (new Detector())->detectForFile($path, 'my-profile');
```

### Overwrite profile options

Alternatively, you may choose to specify custom options for a single detection.
This is also applicable for both detection methods.

```php
// Custom options for the "profile"
$mimeType = (new Detector())->detect($file, 'my-profile', [
    'sample_size' => 5 * 1024 * 1024,
]);

// Or...
$mimeType = (new Detector())->detectForFile($path, 'my-profile', [
    'sample_size' => 5 * 1024 * 1024,
]);
```

## The `MimeType` object

The `MimeType` object that is returned by the `detect()` or `detectForFile()` method contains information about a file's MIME-type.

```php
print_r($mimeType);
```

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

### Properties

You can obtain individual properties via their accessor methods:

```php
$type = $mimeType->type();
$description = $mimeType->description();
$encoding = $mimeType->encoding();
// ... etc
```

For a complete list of available methods, please review `\Aedart\Contracts\MimeTypes\MimeType`.

### When MIME-type not detected

::: warning Caveat
If a MIME-type cannot be detected by `detect()` or `detectForFile`, then you will still receive a `MimeType` instance.
But, all of its properties will be `null`!

To test if a returned `MimeType` instance contains an actual MIME-type, use the `isValid()` method:

```php
if ($mimeType->isValid()) {
    echo $mimeType->type(); // text/plain
} else {
    echo $mimeType->type(); // null
}
```
:::

## Inside Laravel

When situated inside a regular Laravel application, then you can obtain the `Detector` instance by using the `MimeTypeDetectorTrait`.
For instance, if you need to detect a file's MIME-type inside a controller: 

```php
use Aedart\MimeTypes\Traits\MimeTypeDetectorTrait;

class MyController {
    use MimeTypeDetectorTrait;

    public function index()
    {
        $detector = $this->getMimeTypeDetector();
        
        // ... remaining not shown ...
    }
}
```
