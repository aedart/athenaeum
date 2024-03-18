---
description: How to use File Info Driver
---

# File Info

The `FileInfoSampler` is a wrapper for the [`finfo` class](https://www.php.net/manual/en/class.finfo). It requires the [File Info Extension](https://www.php.net/manual/en/book.fileinfo.php) to be installed.

## Options

`FileInfoSampler` offers the following options, which can be specified in your "profile" settings.

_If you are using package in a regular Laravel application, then you can change options in your `config/mime-types-detection.php` file._

```php
use Aedart\MimeTypes\Detector;
use Aedart\MimeTypes\Drivers\FileInfoSampler;

$detector = new Detector([
    'default' => [
        'driver' => FileInfoSampler::class,
        'options' => [
            // Amount of bytes to sample from file
            'sample_size' => 1048576,
            
            // Path to custom magic database
            'magic_database' => null,
        ]
    ],
]);
```

### `sample_size`

The sample size determines how many bytes from a file's content must be used for determining the MIME-type.
The default value of `1048576` bytes (_~1 MB_) corresponds to the default size of the linux [`file` command](https://manpages.debian.org/bullseye/file/file.1.en.html) uses.

Feel free to tinker with this size as you see fit. For instance, during the development of this package a much smaller value (_`512` bytes_) was used during testing.
All test-files' MIME-type were detected as expected. Yet, depending on the files that you attempt to detect MIME-types for, no guarantees can be provided.
In other words, you should test against desired files to see what sample size works.

### `magic_database`

The default value of `null` works in the same way as specified by the [File Extension documentation](https://www.php.net/manual/en/function.finfo-open.php#refsect1-function.finfo-open-notes).
In other words, you are encouraged to just leave it unset.

If you do wish to use a custom `magic` database, then you should look at the [`file` command documentation](https://manpages.debian.org/bullseye/file/file.1.en.html).
In addition, the follow resources may offer some help:

* [tutorial on creating custom `magic` database](http://cweiske.de/tagebuch/custom-magic-db.htm)
* [`magic` — file command's magic pattern file manual](https://manpages.debian.org/bullseye/libmagic1/magic.5.en.html)
