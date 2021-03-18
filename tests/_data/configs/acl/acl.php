<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Models
    |--------------------------------------------------------------------------
    |
    | The Eloquent models to be used by the ACL components.
    */

    'models' => [

        'permission_group' => \Aedart\Acl\Models\Permissions\Group::class
    ],

    /*
    |--------------------------------------------------------------------------
    | Tables
    |--------------------------------------------------------------------------
    |
    | Database table names to apply for the migrations and Eloquent Models.
    */

    'tables' => [

        'groups' => 'permission_groups'

    ]
];