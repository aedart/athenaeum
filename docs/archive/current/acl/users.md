---
description: Assigning Roles to Users
---

# Users

Your Eloquent `User` model should make use of the `HasRoles` trait. It enables assigning and un-assigning of roles.
(_See [setup](./setup.md#the-hasroles-trait)_).

[[TOC]]

## Assign Roles

Use the `assignRoles()` method to assign one or more roles to a user.
The method behaves similarly as the [`grantPermissions()` method](./roles.md#grant-permissions), in that it too accepts a variety of argument types:  

* slugs
* ids
* `Role` model instance
* `Collection` of role model instances
* array of slugs, ids or role model instances.

```php
$role = Role::findBySlug('flight-manager');

// Assign single role
$user->assignRoles($role);

// ... Or via array...

$user->assignRoles([ 'editor', 'reviewer', 'flight-manager' ]);

// ... Or single role via slug

$user->assignRoles('flight-manager');
```

## Un-assign Roles

When you need to un-assign roles, then use the `unassignRoles()`.
It accepts the same type of arguments as the `assignRoles()` method.

```php
$user->unassignRoles([ 'editor', 'flight-manager' ]);
```

### Un-assign all roles

The `unassignAllRoles()` method can be used when you need to un-assign all roles for a user.

```php
$user->unassignAllRoles();
```

## Synchronise roles

If you require synchronising granted permissions, then use the `syncPermissions()` method.

To synchronise assigned roles, use the `syncRoles()` method.

```php
// Regardless of what roles previously were assigned,
// the user will now only be assign to the given roles...
$user->syncRoles([
    'editor',
    'reviewer',
    'flight-manager',
]);
```

For additional information about relations synchronisation, please review Laravel's [documentation](https://laravel.com/docs/13.x/eloquent-relationships#syncing-associations).

## Check user's roles

Determining what roles are assigned to a given user, can be achieved via the following methods:

### Has role

The `hasRoles()` method returns `true`, if given role is assigned to the user.

```php
echo $user->hasRoles('editor'); // e.g. false (0)
```

### Has all roles

To determine if a user has multiple roles assigned, use the `hasAllRoles()`.
The method only returns `true`, if all given roles are assigned.

```php
echo $user->hasAllRoles([ 'editor', 'reviewer' ]); // e.g. false (0)
```

### Has any roles

To determine if a user is assigned either (_one of_) of given roles, use the `hasAnyRoles()` method.

```php
// Returns true if either role is assigned
echo $user->hasAnyRoles([ 'editor', 'reviewer' ]); // e.g. true (1)
```

## Check user's permissions

During runtime, if you have defined permissions in the `AuthServiceProvider` (See [setup](./setup.md)), you can use [Laravel's builtin mechanisms](https://laravel.com/docs/13.x/authorization#authorizing-actions-using-policies) to check a user's permissions.

```php
<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Flight;
use Illuminate\Http\Request;

class FlightController extends Controller
{

    public function update(Request $request, Flight $flight)
    {
        if (!$request->user()->can('flights.update', $flight)) {
            abort(403);
        }

        // The current user can update the flight post...
    }
}
```

### Cached permissions

It is important to understand that when using the ACL `Registrar` in your `AuthServiceProvider`, all permissions will be cached.
Unless you are aware of this, you can experience unexpected behavior, should you change a user's roles, permissions...etc.

See [Cached Permissions section](./cache.md) for additional information.

### Manual database check

Should you require checking if a user is granted a specific permission, without using the cache, then you may use the `hasPermission()` method.
It ONLY accepts a `Permission` model instance as argument and will perform a database query, to determine whether the user is granted the given permission or not.

```php
$permission = Permission::findBySlug('flights.destroy');

echo $user->hasPermission($permission); // E.g. true (1)
```
