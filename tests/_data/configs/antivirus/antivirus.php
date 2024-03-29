<?php

use Aedart\Contracts\Streams\BufferSizes;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Antivirus Scanner
    |--------------------------------------------------------------------------
    */

    'default_scanner' => env('DEFAULT_ANTIVIRUS_SCANNER', 'clamav'),

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
                'socket' => env('CLAMAV_SOCKET', 'unix:///var/run/clamav/clamd.ctl'),

                // Socket connection timeout (in seconds). If null, then
                // the timeout is disabled!
                'socket_timeout' => env('CLAMAV_SOCKET_TIMEOUT', 2),

                // Timeout (in seconds) timeout for obtaining scan results.
                'timeout' => env('CLAMAV_SCAN_TIMEOUT', 30),

                // Maximum amount of bytes to send to the ClamAV client, in a single chunk.
                // This value SHOULD NOT exceed "StreamMaxLength", defined in your clamd.conf (default 25 Mb).
                'chunk_size' => env('CLAMAV_STREAM_CHUNK_SIZE', BufferSizes::BUFFER_1MB * 10),

                // When dealing with PSR-7 Uploaded Files / Streams
                // See documentation for additional details.
                // 'temporary_stream_max_memory' => BufferSizes::BUFFER_1MB * 2,
                // 'stream_buffer_size' => BufferSizes::BUFFER_1MB * 2,
            ],
        ],

        'null' => [
            'driver' => \Aedart\Antivirus\Scanners\NullScanner::class,
            'options' => [
                'should_pass' => false,
            ],
        ],

        // When tests are not intended to run LIVE and use native drivers, connections,...etc
        'pass' => [
            'driver' => \Aedart\Antivirus\Scanners\NullScanner::class,
            'options' => [
                'should_pass' => true,
            ],
        ],
        'fail' => [
            'driver' => \Aedart\Antivirus\Scanners\NullScanner::class,
            'options' => [
                'should_pass' => false,
            ],
        ]
    ]
];
