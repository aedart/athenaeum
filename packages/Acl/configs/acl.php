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

        'role' => \Aedart\Acl\Models\Role::class,

        'permission' => \Aedart\Acl\Models\Permission::class,

        'group' => \Aedart\Acl\Models\Permissions\Group::class
    ],

    /*
    |--------------------------------------------------------------------------
    | Tables
    |--------------------------------------------------------------------------
    |
    | Database table names to apply for the migrations and Eloquent Models.
    */

    'tables' => [

        'roles' => 'roles',

        'roles_permissions' => 'roles_permissions',

        'permissions' => 'permissions',

        'groups' => 'permission_groups'

    ]
];
