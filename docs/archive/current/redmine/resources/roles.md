---
description: Redmine Roles
sidebarDepth: 0
---

# Roles

When working with [project memberships](./memberships.md), you will be required to state which role(s) users are groups are to be granted, when assigned to a proejct.
Unfortunately, Redmine's API does not permit creating these roles; _you can only read the existing roles via the API!_.
See [Redmine's API documentation](https://www.redmine.org/projects/redmine/wiki/Rest_Roles) for details.

## Fetch roles list

WHen you fetch the list of roles, you are only provided with an id and a name for the role. It will NOT contain all details about a given role.

```php
use Aedart\Redmine\Role;

$roles = Role::list(); 
```

**Note**: _The roles API resource does not support pagination!_

## Fetch single role

If you require additional details about a role, e.g. what permissions it grants, then you must obtain the role by it's id.

```php
$role = Role::findOrFail(6);

$permissions = $role->permissions;
```