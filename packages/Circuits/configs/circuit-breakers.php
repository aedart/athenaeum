<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Circuit Breakers
    |--------------------------------------------------------------------------
    |
    | List of services (profiles), each containing options for a corresponding
    | circuit breaker
    */

    'services' => [

        'my_service' => [

            /*
             * Name of store to use
             */
            'store' => 'default',

            /*
             * Maximum amount of times that a callback should
             * be attempted
             */
            'retries' => 1,

            /*
             * Amount of milliseconds to wait before each attempt
             */
            'delay' => 100,

            /*
             * Maximum amount of failures before circuit breaker
             * must trip (change state to "open")
             */
            'failure_threshold' => 1,

            /*
             * Grace period duration.
             *
             * The amount of seconds to wait before circuit breaker can
             * attempt to change state to "half open", after failure
             * threshold has been reached.
             */
            'grace_period' => 10,

            /*
             * Timezone
             */
            'timezone' => env('TIMEZONE', 'UTC'),

            /*
             * Time-to-live (ttl) for a state
             *
             * Duration in seconds. When none given, it defaults to
             * store's ttl.
             */
            'state_ttl' => null,
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Stores
    |--------------------------------------------------------------------------
    |
    | Name of default circuit breaker store to use, when none specified.
    */

    'default_store' => env('CIRCUIT_BREAKER_STORE', 'default'),

    /*
    |--------------------------------------------------------------------------
    | Stores
    |--------------------------------------------------------------------------
    |
    | List of stores that are able to keep track of circuit breakers' state,
    | failures and grace period.
    */

    'stores' => [

        'default' => [
            'driver' => \Aedart\Circuits\Stores\CacheStore::class,
            'options' => [

                /*
                 * Name of Laravel Cache Store to use
                 *
                 * WARNING: Cache Store MUST inherit from LockProvider or
                 * it cannot be used.
                 *
                 * @see \Illuminate\Contracts\Cache\LockProvider
                 */
                'cache-store' => 'redis',

                /*
                 * Default time-to-live (ttl) for a state.
                 */
                'ttl' => 3600,
            ]
        ]
    ]
];
