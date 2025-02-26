---
description: Working with roles
---

# Roles

Roles are the responsible for grouping granted permissions. A role has be assigned to one or more users and thereby granting the users whatever permissions are granted to the role itself.

[[TOC]]

## Creating a new role

To create a new role, you can use the static `create()` method, as you normally would in your Eloquent model.

```php
use Aedart\Acl\Models\Role;

$manager = Role::create([
    'slug' => 'flight-manager',
    'name' => 'Flight manager',
    'description' => 'Responsible for managing flight records'
]);
```

See Laravel's [documentation](https://laravel.com/docs/11.x/eloquent#inserting-and-updating-models) for additional information on how to create new records.

### New role with permissions

If you already know which permissions a new role should be granted, then you can define these right away, during the role's creation.
This is done so, via the `createWithPermissions()` method.

```php
use Aedart\Acl\Models\Permissions\Group;
use Aedart\Acl\Models\Role; 

$permissions = Group::findBySlug('flights')->permissions;

$manager = Role::create([
    'slug' => 'flight-manager',
    'name' => 'Flight manager',
    'description' => 'Responsible for managing flight records'
], $permissions);
```

## Grant permissions

The `grantPermissions()` method allows you to grant one or more permissions to the given role.
The method can accept multiple types of permission identifiers:

* `string`: permission's unique slug
* `int`: permissions unique id (_integer_)
* `Permission`: instance of Permission model
* `Collection`: a collection of permission models
* `array`: list of permission slugs, ids or models

```php
$role = Role::findBySlug('flight-manager');
$role->grantPermissions($permissions);

// ... Or via array...

$role->grantPermissions([ 'flights.index', 'flights.show', 'flights.store' ]);

// ... Or single permission via slug

$role->grantPermissions('flights.destroy');
```

## Revoke permissions

To revoke permissions from an existing role, use the `revokePermissions()` method.
It accepts the same type of arguments as the `grantPermissions()` method.

```php
$role->revokePermissions([ 'flights.update', 'flights.destroy' ]);
```

### Revoking all permissions

Use the `revokeAllPermissions()` method to revoke all permissions for given role.

```php
$role->revokeAllPermissions();
```

## Synchronise permissions

If you require synchronising granted permissions, then use the `syncPermissions()` method. 

```php
// Regardless of what permissions previously were granted,
// the role will now only be granted the given permissions...
$role->syncPermissions([
    'flights.index',
    'flights.show',
    'flights.store',
]);
```

For additional information about relations synchronisation, please review Laravel's [documentation](https://laravel.com/docs/11.x/eloquent-relationships#syncing-associations).

## Update role with permissions

To update a role's attributes and also grant it permissions, use the `updateAndGrantPermissions()` method.

```php
$permissions = [ 'flights.index', 'flights.show' ];

$role = Role::findBySlug('flight-manager');
$role->updateAndGrantPermissions([
    'description' => 'Responsible for supervising flight records'
], $permissions);
```

### Update and synchronise permissions

Alternatively, you may also synchronise permissions when updating an existing role.

```php
$permissions = [ 'flights.index', 'flights.show' ];

$role = Role::findBySlug('flight-manager');
$role->updateAndSyncPermissions([
    'description' => 'Responsible for supervising flight records'
], $permissions);
```

## Check role's permissions

When you need to determine whether a role has specific permissions or not, then the following methods can be used.

### Has permission

The `hasPermission()` method returns `true`, if given permission are granted to the role. 

```php
echo $role->hasPermission('flights.update'); // e.g. false (0)
```

### Has all permissions

To determine if a role has multiple permissions granted, use the `hasAllPermissions()`.
The method only returns `true`, if all given permissions are granted.

```php
echo $role->hasAllPermissions([ 'flights.destroy', 'flights.store' ]); // e.g. true (1)
```

### Has any permissions

Lastly, to determine if a role has either (_one of_) of given permissions, use the `hasAnyPermissions()` method.

```php
// Returns true if either permission is granted
echo $role->hasAnyPermissions([ 'flights.index', 'flights.show' ]); // e.g. true (1)
```
