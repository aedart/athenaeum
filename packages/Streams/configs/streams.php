<?php

return [

    /*
     |--------------------------------------------------------------------------
     | Default Stream profiles
     |--------------------------------------------------------------------------
     |
     | The default connection profiles to be used, when no specific transaction
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
            'driver' => \Aedart\Streams\Locks\Drivers\FlockLockDriver::class,
            'options' => [

                // Sleep duration between acquire lock polling.
                // Duration in microseconds (default 0.01 seconds)
                'sleep' => 10_000,

                // State whether to throw exception if timeout reached, or not...
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

                // When true, a physical backup of the target stream will be created.
                // (This is NOT the same as the temporary file that is processed!)
                'backup' => true,

                // Location of where backup files are to be stored.
                'backup_directory' => storage_path('backups'),

                // When true and commit is successful, backup file is automatically
                // removed. Has no effect if backup is set to false.
                'remove_backup_after_commit' => false,
            ]
        ]
    ]
];
