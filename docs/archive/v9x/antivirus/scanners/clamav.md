---
description: About ClamAV Scanner
sidebarDepth: 0
---

# ClamAV

**Driver**: `\Aedart\Antivirus\Scanners\ClamAv`

Behind the scene, this scanner acts as an adapter for [xenolope/quahog](https://github.com/jonjomckay/quahog).

## Prerequisites

A [ClamAV](https://www.clamav.net/) client must be available on your server (_or local environment_). 

## Options

The following shows the available options for the ClamAv scanner.

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

        'clamav' => [
            'driver' => \Aedart\Antivirus\Scanners\ClamAv::class,
            'options' => [

                // Socket address to the ClamAV client
                // E.g.:
                // - Unix socket: 'unix:///var/run/clamav/clamd.ctl'
                // - TCP socket: 'tcp://127.0.0.1:3310'
                'socket' => 'unix:///var/run/clamav/clamd.ctl',

                // Socket connection timeout (in seconds). If null, then
                // the timeout is disabled!
                'socket_timeout' => 2,

                // Timeout (in seconds) timeout for obtaining scan results.
                'timeout' => 30,

                // Maximum amount of bytes to send to the ClamAV client,
                // in a single chunk. This value SHOULD NOT exceed "StreamMaxLength",
                // defined in your clamd.conf (default 25 Mb).
                'chunk_size' => BufferSizes::BUFFER_1MB * 10,
            ],
        ],
        
        // ...other profiles not shown...
    ]
];
```