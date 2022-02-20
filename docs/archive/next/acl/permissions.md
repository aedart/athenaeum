---
description: How to install new permissions
---

# Permissions

Before you are able to grant permissions to roles, they must first be created. But, as you might have noticed, each permission must belong to a permission group.
This makes creating permissions slightly cumbersome. Therefore, to ease permissions creation, you can make use of the `createWithPermissions()` method, in the permissions group model.

[[TOC]]

## Create new migration

Your application _SHOULD_ be [coded against it's available permissions](https://spatie.be/docs/laravel-permission/v4/best-practices/roles-vs-permissions).
It would therefore be beneficial to install them via database migrations.

```shell
php artisan make:migration installs_flight_permissions
```

## Create Permissions and Group

Inside your migration class, use the `createWithPermissions()` method to create a new permissions group, with it's desired permissions.
The method accepts a unique slug identifier, along with an array of permissions. The array has to be formatted accordingly:

* key: unique permission slug (_prefixed with group's slug_)
* value: array containing permission's name and description (_optional_)

```php
<?php

use Aedart\Acl\Models\Permissions\Group;
use Illuminate\Database\Migrations\Migration;

class InstallsFlightPermissions extends Migration
{
    public function up()
    {
        $name = 'Flight permissions'; 
        $description = 'Permissions related to flight records';

        Group::createWithPermissions('flights', [
            'index' => [
                'name' => 'List flights',
                'description' => 'Ability to view list of flights'
            ],
            'show' => [
                'name' => 'Show flight',
                'description' => 'Ability to view a single flight'
            ],
            
            // ... remaining not shown ...
        ], $name, $description);
    }

    public function down()
    {
        Group::findBySlugOrFail('flights')->forceDelete();
    }
}
```

## Permission slug prefixes

In the above example, a new permission group is created, using `flights` as it's slug identifier. Each permission's slug is prefixed with the group's slug, separated by a dot (`.`).
Thus, from the above example, the following permission slugs are inserted into the database:

* `flights.index`
* `flights.show`

Later in you application, you will be able to check against these permissions:

```php
<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FlightController extends Controller
{

    public function index(Request $request)
    {
        if ($request->user()->cannot('flights.index')) {
            abort(403);
        }

        // ...remaining not shown
    }
}
```

### Disable prefixes

If you do not wish your permission's slugs to be prefixed, then you can disable this behaviour by setting the `$prefix` argument to `false`, when using the `createWithPermissions()` method.

```php
$name = 'Flight permissions'; 
$description = 'Permissions related to flight records';
$prefix = false;

Group::createWithPermissions('flights', [
    'show-flights-list' => [
        'name' => 'List flights',
        'description' => 'Ability to view list of flights'
    ],
    
    // ... remaining not shown ...
], $name, $description, $prefix);
```

From the above example, the following permission slug is inserted into the database:

* `show-flights-list`

::: tip How should you name your permissions?
If you find yourself wondering how you should name your permission slugs, perhaps you can use the same names as for your routes.

See Laravel's [resource routes](https://laravel.com/docs/8.x/controllers#actions-handled-by-resource-controller) documentation for inspiration.
:::

## Find or create behaviour

The `createWithPermissions()` method attempts to find a permissions group with the requested slug. Only if the group does not exist, then it will be created.
This allows you to add more permissions to the same group, at a later point.

::: warning Caution
The "find or create" behaviour does NOT apply to the permissions. Each given permission is attempted created.
This means that if you provide a permission slug that already exists, then `createWithPermissions()` will fails with a _"unique key constraint violation"_ database exception.

Should you wish to change a permission, then you will have to do so manually, e.g. by using the `Permission` Eloquent model. 
:::
