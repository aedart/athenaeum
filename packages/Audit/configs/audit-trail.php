<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Audit Trail Model
    |--------------------------------------------------------------------------
    |
    | The Eloquent model to be used for audit trail
    */

    'models' => [

        // Your application's user model
        'user' => \App\Models\User::class,

        // The Audit Trail model
        'audit_trail' => \Aedart\Audit\Models\AuditTrail::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Database table
    |--------------------------------------------------------------------------
    |
    | Name of the database table that contains audit trail
    */

    'table' => 'audit_trails',

    /*
    |--------------------------------------------------------------------------
    | Attributes Column Datatype
    |--------------------------------------------------------------------------
    |
    | Table column datatype of the "original_data" and "changed_data" attributes.
    | Accepts json, jsonb or text.
    |
    | NOTE: Changing this value after migration has run will have no effect!
    |
    | @see https://www.compose.com/articles/faster-operations-with-the-jsonb-data-type-in-postgresql/
    */

    'attributes_column_type' => 'json',

    /*
    |--------------------------------------------------------------------------
    | Eloquent Model Observer
    |--------------------------------------------------------------------------
    |
    | Class path of the Eloquent Model Observer responsible for listening to
    | relevant events and re-dispatch them as a "model has changed" event
    |
    | @see \Aedart\Audit\Events\ModelHasChanged
    | @see https://laravel.com/docs/8.x/eloquent#observers
    */

    'observer' => \Aedart\Audit\Observers\ModelObserver::class,

    /*
    |--------------------------------------------------------------------------
    | Event Listeners
    |--------------------------------------------------------------------------
    |
    | Class path to event subscriber that is responsible for recording Audit Trail
    | Entry, based on received events.
    */

    'subscriber' => \Aedart\Audit\Subscribers\AuditTrailEventSubscriber::class,

    /*
    |--------------------------------------------------------------------------
    | Queue Settings
    |--------------------------------------------------------------------------
    |
    | Default queue settings for the "model has changed" event listener
    */

    'queue' => [

        // Queue connection that the job should be sent to
        'connection' => env('QUEUE_CONNECTION', 'sync'),

        // Name of the queue the job should be sent to
        'queue' => 'default',

        // Time (seconds) before the job should be processed
        'delay' => null,

        // Maximum amount of retries before job is marked as failed
        'retries' => 1
    ]
];
