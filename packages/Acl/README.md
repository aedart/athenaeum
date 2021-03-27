# Athenaeum Acl

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

## Documentation

Please read the [official documentation](https://aedart.github.io/athenaeum/) for additional information.

## Repository

The mono repository is located at [github.com/aedart/athenaeum](https://github.com/aedart/athenaeum)

## Versioning

This package follows [Semantic Versioning 2.0.0](http://semver.org/)

## License

[BSD-3-Clause](http://spdx.org/licenses/BSD-3-Clause), Read the LICENSE file included in this package
