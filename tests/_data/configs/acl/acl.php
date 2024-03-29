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

        'user' => \Aedart\Tests\Helpers\Dummies\Acl\User::class,

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

        // Table name for pivot table between users and roles
        'users_roles' => 'user_role_pivot',

        // Roles table name
        'roles' => 'roles',

        // Table name for pivot table between roles and permissions
        'roles_permissions' => 'role_permission_pivot',

        // Permissions table name
        'permissions' => 'permissions',

        // Permission groups table name
        'groups' => 'permission_groups'
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache
    |--------------------------------------------------------------------------
    |
    | Permissions cache settings for the Acl registrar.
    */

    'cache' => [

        // Name of the cache store (driver profile) to use.
        'store' => 'array',

        // Time-to-live for cached permissions. (seconds)
        'ttl' => 60 * 60,

        // Cache key name to use for permissions
        'key' => 'acl.permissions'
    ]
];
