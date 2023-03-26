---
description: How to setup ACL
---

# Setup

In this section, setup of the ACL package is covered. It goes without saying, you should have some prior knowledge about how to work with Laravel's [Authorization](https://laravel.com/docs/10.x/authorization), before attempting to use this package's components.

[[TOC]]

## Register Service Provider

Register `AclServiceProvider` inside your `config/app.php`. 

```php
return [

    // ... previous not shown ... //

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    */

    'providers' => [

        \Aedart\Acl\Providers\AclServiceProvider::class

        // ... remaining services not shown ... //
    ],
];
```

## Publish Assets (optional)

Run `vendor:publish` to publish this package's configuration.

```shell
php artisan vendor:publish
```

After the command has completed, you should see `config/acl.php` in your application.

### Publish Assets for Athenaeum Core Application

If you are using the [Athenaeum Core Application](../../core), then run the following command to publish assets:

```shell
php {your-cli-app} vendor:publish-all
```

## Configuration

Inside the `config/acl.php` file, you can change configuration for this package.

### Using your own models

By default, this package's Eloquent models are used when interacting the various ACL components. To this this, simply state the class paths of your own models, in the `models` setting.

::: tip Note
If you choose to use your own models, then please make sure that they extend this package's Eloquent models - _otherwise you will experience unexpected behavior_.
:::

```php
<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Models
    |--------------------------------------------------------------------------
    */

    'models' => [

        'user' => \App\Models\User::class,

        'role' => \App\Models\Acl\Role::class,

        'permission' => \App\Models\Acl\Permission::class,

        'group' => \App\Models\Acl\Permissions\Group::class
    ],

    // ... remaining not shown
];
```

## The `HasRoles` trait

Your Eloquent `User` model must make use of the `HasRoles` trait. This will ensure that users can be assigned roles and thereby be granted permissions.

```php
<?php

namespace App\Models;

use Aedart\Acl\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasRoles;
}

```

## Migrate the database

Once you have configured the ACL components to your liking, you must migrate the database, so that the various tables can be installed.

```shell
php artisan migrate
```

::: tip Note
The current version of this package does not publish it's database migration files. They are loaded directly via `AclServiceProvider`, when the `artisan migrate` command is executed.
:::

## Define permissions for Gate

To ensure that Laravel's Authorisation Gate component is able to distinguish between which permission a user is granted or not, you must define these in your application's `\App\Providers\AuthServiceProvider` class.
This can easily be accomplished via the ACL `Registrar` component's `define()` method.

```php
<?php

namespace App\Providers;

use Aedart\Acl\Traits\RegistrarTrait;
use App\Models\User;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    use RegistrarTrait;

    // ... previous not shown ...

    public function boot(Gate $gate)
    {
        $this->registerPolicies();
        
        $this->getRegistrar()->define($gate);
    }
}
```

### When acl tables are missing...

::: warning CI environment
If you have a [CI](https://en.wikipedia.org/wiki/Continuous_integration) environment, you might experience a _"missing permissions table"_ failure, when installing a fresh instance of the application.
This will happen when the `AuthServiceProvider`'s `boot()` is invoked, before migrations are installed.

A possible solution for this, is to safely ignore the `QueryException`. E.g.:

```php
use Aedart\Utils\Str;
use Illuminate\Database\QueryException;

try {
    $this->getRegistrar()->define($gate);
} catch(QueryException $e) {
    // Ignore exception - BUT ONLY IF it concerns missing permissions table!
    // Otherwise, re-throw the exception...
    if (!Str::contains($e->getMessage(), [
        'could not find driver (SQL: select * from `permissions`)',
        'relation "permissions" does not exist'
    ])) {
        throw $e;
    }
}
```

This issue can be very frustrating. Yet, this package dares not assume how to deal missing with migrations or boot order of your service providers.
:::

## Onward

You should now be ready to start working with the ACL components. In the upcoming sections, how to create permissions, roles, granting & revoking permissions ...etc, is covered in details. 
