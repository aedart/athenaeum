<?php

return [

    /*
     |--------------------------------------------------------------------------
     | Default Stream profiles
     |--------------------------------------------------------------------------
     |
     | The default profiles to be used, when no specific transaction
     | or lock profile requested.
    */

    'default_lock' => env('STREAM_LOCK', 'default'),

    'default_transaction' => env('STREAM_TRANSACTION', 'default'),

    /*
     |--------------------------------------------------------------------------
     | Lock profiles
     |--------------------------------------------------------------------------
     |
     | List of available lock profiles.
    */

    'locks' => [

        'default' => [
            'driver' => \Aedart\Streams\Locks\Drivers\FLockDriver::class,
            'options' => [

                // Sleep duration between acquire lock polling.
                // Duration in microseconds (default 0.01 seconds)
                'sleep' => 10_000,

                // State whether to throw exception if timeout reached, or not...
                'fail_on_timeout' => true
            ]
        ],

        'flock' => [
            'driver' => \Aedart\Streams\Locks\Drivers\FLockDriver::class,
            'options' => [
                'sleep' => 10_000,
                'fail_on_timeout' => true
            ]
        ]
    ],

    /*
     |--------------------------------------------------------------------------
     | Transaction profiles
     |--------------------------------------------------------------------------
     |
     | List of available lock profiles.
    */

    'transactions' => [

        'default' => [
            'driver' => \Aedart\Streams\Transactions\Drivers\CopyWriteReplaceDriver::class,
            'options' => [

                // The maximum memory size, before processed stream is written to
                // a temporary file by PHP.
                'maxMemory' => 5 * \Aedart\Contracts\Streams\BufferSizes::BUFFER_1MB,

                // Lock settings
                'lock' => [

                    // When true, the stream will be locked during transaction
                    'enabled' => true,

                    // Name of the lock profile to be used
                    'profile' => env('STREAM_LOCK', 'default'),

                    // Type of lock to be used
                    'type' => \Aedart\Contracts\Streams\Locks\LockType::EXCLUSIVE,

                    // Acquire lock timeout in seconds
                    'timeout' => 0.01,
                ],

                // Backup settings
                'backup' => [

                    // When true, a backup of target stream (*.bak file) will be stored
                    'enabled' => false,

                    // Location of backup files
                    'directory' => 'tests/_output/streams/backup',

                    // When true, backup file is automatically removed after commit.
                    'remove_after_commit' => false,
                ],
            ],
        ],

        'cwr' => [
            'driver' => \Aedart\Streams\Transactions\Drivers\CopyWriteReplaceDriver::class,
            'options' => [

                'maxMemory' => 5 * \Aedart\Contracts\Streams\BufferSizes::BUFFER_1MB,
                'lock' => [
                    'enabled' => true,
                    'profile' => env('STREAM_LOCK', 'default'),
                    'type' => \Aedart\Contracts\Streams\Locks\LockType::EXCLUSIVE,
                    'timeout' => 0.01,
                ],

                // Backup settings
                'backup' => [
                    'enabled' => true,
                    'directory' => 'tests/_output/streams/backup',
                    'remove_after_commit' => false,
                ],
            ]
        ]
    ]
];
