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
];
