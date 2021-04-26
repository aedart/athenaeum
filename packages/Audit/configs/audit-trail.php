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
];
