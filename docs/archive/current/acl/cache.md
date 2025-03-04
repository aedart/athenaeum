---
description: Working with cached permissions
---

# Cached Permissions

By default, all permissions and their associated roles are cached by the ACL `Registrar`, which you can use in your `AuthServiceProvider`, to define the permissions and how to resolve them (_See [setup](./setup.md) for additional information_).
In this section, you will find a brief introduction for how to manage the cache permissions. 

[[TOC]]

## Configuration

In your `config/acl.php` configuration file, you will find a `cache` setting.
Here you can customise what cache store to use, how long permissions & roles should be cached, and what key-prefix should be used. 

```php
<?php

return [

    // ... previous not shown ...

    /*
    |--------------------------------------------------------------------------
    | Cache
    |--------------------------------------------------------------------------
    */

    'cache' => [

        // Name of the cache store (driver profile) to use.
        'store' => 'default',

        // Time-to-live for cached permissions. (seconds)
        'ttl' => 60 * 60,

        // Cache key name to use for permissions
        'key' => 'acl.permissions'
    ]
];
```

## When changing permissions and roles

When you change your permissions or roles in the database, you will be required to flush the cached counterparts manually.
The ACL `Registrar` offers a convenient way of doing so, via the `flush()` method.

In the following example, it is assumed that a web-interface exists for managing users' roles.
Once a role has been updated, the cached permissions & roles can be cleared by invoking the mentioned `flush()` method.

```php
<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Roles;
use Illuminate\Http\Request;
use Aedart\Acl\Traits\RegistrarTrait;

class RolesController extends Controller
{
    use RegistrarTrait;
    
    public function update(Request $request, Role $role)
    {
        // ... update logic not shown ...
        
        $this->getRegistrar()->flush();    
    }
    
    // ... remaining not shown ...
}
```

### No auto-flush offered

The current ACL package does not offer any automatic way of flushing the cached permissions & roles.
Should you require such logic, then you may accomplish this via Eloquent's [events](https://laravel.com/docs/12.x/eloquent#events) and [event observers](https://laravel.com/docs/12.x/eloquent#observers).


