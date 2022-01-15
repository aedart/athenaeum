---
description: About the ACL Package
---

# Introduction

_**Available since** `v5.10.x`_

Offers a small [ACL](https://da.wikipedia.org/wiki/Access_control_list) implementation for Laravel, with roles and permissions (grouped) that are stored in a database.

## Database tables

The following diagram illustrates the database tables (_pivot tables not shown_).

```
┌───────┐
│ users │
└───┬───┘
    │
    │  Each user can be assigned none or many roles
    │
┌───▼───┐
│ roles │
└───┬───┘
    │
    │  Each role is granted none or many permissions
    │
┌───▼─────────┐
│ permissions │
└───┬─────────┘
    │
    │  Each permission belongs to a group of permissions
    │
┌───▼────┐
│ groups │
└────────┘
```

## Alternatives

There are many ACL alternatives available, for Laravel.
Amongst them is the [Spatie Laravel Permission](https://packagist.org/packages/spatie/laravel-permission) package, which has been a great source of inspiration for this package.

Please know that this package's implementation and core concept differs from that of Spatie.
The _"Laravel Permission"_ permission package allows you to grant permissions directly to user model, if you wish. This package does not allow such - permissions can only be granted to roles.
Nevertheless, [Spatie](https://packagist.org/packages/spatie/laravel-permission) offers support for multiple [Guards](https://spatie.be/docs/laravel-permission/v4/basic-usage/multiple-guards) and tons of other nice features.
You are encouraged to review their [documentation](https://spatie.be/docs/laravel-permission/v4/introduction), before proceeding here. 
