---
description: List resources
sidebarDepth: 0
---

# Fetch list of resources

The `list()` method allows you to quickly obtain a list of existing resources.

```php
use Aedart\Redmine\Issue;

$issues = Issue::list();

foreach ($issues as $issue) {
    // ... do something with issue.
}
```

## Pagination

By default, the requested list is paginated, returning only the first `10` results.
You can specify the limit and offset, as the first two arguments of the `list()` method.

```php
$issues = Issue::list(10, 5); // Limit 10, offset 5...

// Paginated results also contains meta information...
$limit = $issues->limit();
$offset = $issues->offset();
```

## Include Associated Data

Some resources support including associated data as part of the response. For instance, the `Issue` resource can request to include "relations".
The 3rd argument of the `list()` method accepts an array of "associated data" identifiers. 

```php
$issues = Issue::list(10, 0, [ 'relations' ]);

foreach ($issues as $issue) {
    $relations = $issue->relations;
}
```

Please review each resource's [API documentation](https://www.redmine.org/projects/redmine/wiki/rest_api) to see what associated data can be requested included.