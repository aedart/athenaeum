---
description: Creating new records in Redmine
sidebarDepth: 0
---

# Create new record

The `create()` method can be used when you wish to create a new record in Redmine.

```php
$issue = Issue::create([
    'project_id' => 42,
    'status_id' => 1,
    'tracker_id' => 2,
    'subject' => 'Lorum lipsum...',
]);
```

Alternatively, you can invoke the `save()` method after having populated a new instance.

```php
$issue = Issue::make([
    'project_id' => 42,
    'status_id' => 1,
    'tracker_id' => 2,
    'subject' => 'Lorum lipsum...',
])->save();
```