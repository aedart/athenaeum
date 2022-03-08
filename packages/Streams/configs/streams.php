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
            'driver' => null, // TODO...
            'options' => []
        ]
    ]
];
