---
description: Using PSR Uploaded Files or Streams
sidebarDepth: 0
title: PSR
---

# PSR Uploaded Files & Streams

Internally, the `scan()` method wraps its file argument into a [`FileStream`](../streams/README.md) before processing it.
When a [PSR-7 uploaded file](https://www.php-fig.org/psr/psr-7/#36-psrhttpmessageuploadedfileinterface) instance is provided, its [`Stream`](https://www.php-fig.org/psr/psr-7/#34-psrhttpmessagestreaminterface) will be extracted and **copied** into a new [temporary `FileStream`](../streams/usage/writing.md#copy-from).
This behaviour ensures that the original stream is not [detached](../streams/usage/open-close.md#detaching-resource), and you can safely continue to work with it after a scan has been performed.

```php
$result = $scanner->scan($psrUploadedFile); // PSR Stream is copied...

// Later...
$stream = $psrUploadedFile->getStream();
echo $stream->getContents(); // You can safely use the stream
```

The above described stream copy behaviour applies **ONLY** to PSR-7 streams that are not instance of [`FileStream`](../streams/README.md).

## Performance

The PSR stream copy behaviour may cause some performance issues for your application.
This is especially true, if you plan to scan files of large filesize.
If that is the case, please consider detaching the PSR stream.
Doing so ensures that the copy behaviour is entirely omitted. 

```php
use Aedart\Streams\FileStream;

// Detach PSR stream, wrap it into a new stream
$fileStream = FileStream::makeFrom(
    $psrUploadedFile->getStream()
);

$result = $scanner->scan($fileStream);

// Later...
echo $fileStream->getContents();
```

If the above is not possible for you, then consider tinkering with the stream copy options, which are available for all scanners.
In your `config/antivirus.php`, you may add the following options and configure them as you see fit.

* `temporary_stream_max_memory`, the maximum memory limit in bytes, before PHP's internal mechanisms write to a physical file.
* `stream_buffer_size` amount of bytes to read from PSR stream, per read iteration (_buffer_). 

Both values default to 2 Mb, if not specified in the profile's options.

```php
use Aedart\Contracts\Streams\BufferSizes;

return [

    // ...previous not shown...

    /*
    |--------------------------------------------------------------------------
    | Scanner Profiles
    |--------------------------------------------------------------------------
    */

    'profiles' => [

        'default' => [
            'driver' => \Aedart\Antivirus\Scanners\ClamAv::class,
            'options' => [

                // When dealing with PSR-7 Uploaded Files / Streams
                'temporary_stream_max_memory' => BufferSizes::BUFFER_1MB * 2,
                'stream_buffer_size' => BufferSizes::BUFFER_1MB * 2,
                
                // ...other options not shown...
            ],
        ],

        // ... other profiles not shown...
    ]
];

```