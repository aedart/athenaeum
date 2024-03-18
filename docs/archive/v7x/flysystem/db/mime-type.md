---
description: Database Adapter's MIME-Type detection
sidebarDepth: 0
---

# MIME-Type Detection

The Database Adapter uses the [MIME-Type Detector package](../../mime-types/README.md) to detect files' MIME-Type.
When a file is written, the MIME-Type is automatically detected at set.

::: tip Note
The [MIME-Type Detector package](../../mime-types/README.md) behaves differently than [league/mime-type-detection](https://packagist.org/packages/league/mime-type-detection).
It does not offer any fallback mechanism that uses a file's extension. MIME-Type is detected ONLY via a file's content! 
:::

## Specify Custom MIME-Type

You can choose to provide a custom MIME-Type via the `$config` array argument, when writing a file.

```php
$filesystem->write('books/great_new_world.txt', '...', [
    'mime_type' => 'application/ext-custom'
])
```

## Custom MIME-Type Detector Callback

Alternatively, if the default provided MIME-Type detection mechanism is not to your liking, then you can specify a custom callback to perform detection.
The following example shows how you switch the default detection to [league/mime-type-detection](https://packagist.org/packages/league/mime-type-detection).

```php
use Aedart\Contracts\Streams\FileStream;
use League\Flysystem\Config;
use League\MimeTypeDetection\FinfoMimeTypeDetector;

$adapter->detectMimeTypeUsing(function(FileStream $stream, Config $config) {
    $detector = new FinfoMimeTypeDetector();

    $content = $stream->read(512);
    $uri = $stream->uri();
    
    $stream->positionToStart();

    return $detector->detectMimeType($uri, $content);
});
```

The callback MUST return a string MIME-Type or `null`, if unable to detect.