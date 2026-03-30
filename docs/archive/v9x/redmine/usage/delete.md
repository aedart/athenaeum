---
description: Delete records in Redmine
sidebarDepth: 0
---

# Delete existing record

The `delete()` method will request a record to be deleted from Redmine.

```php
$issue->delete();
```

## Deleting multiple records

Sadly, Redmine does not support deleting multiple records in a single request. This means that each record you wish to remove, will cost a request.

```php
$issues = Issue::fetchMultiple(function(Builder $request, Resource $resource) {
    return $request
        ->where('created_on', '><2020-01-01|2021-08-30')
        ->where('status_id', 'closed')
        ->where('assigned_to_id', 'me');
}, 10, 8);

// Remove found list of records... will take time!
foreach($issues as $issue) {
    $issue->delete();
}
```