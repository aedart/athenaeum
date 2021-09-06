---
description: Update records in Redmine
sidebarDepth: 0
---

# Update existing record

You can use the `update()` method to change an existing record.

```php
$issue->update([
    'subject' => 'Perform review of component ABC',
]);
```

Alternatively, you may also use the `save()` method to achieve the same.

```php
$issue->subject = 'Add docs for build process';
$issue->save();
```

## "Force" reload

Redmine's API does not automatically return an updated record, when you request existing records changed.
To reload and obtain the updated record from Redmine, you can specify the second argument of the `update()` method.

```php
$issue->update([
    'subject' => 'STEIN 12.1 adjustment',
], true); // Force reload
```

This can also be done via the `save()` method.

```php
$issue->save(true); // Force reload
```

### `reload()`

Behind the scene, `update()` and `save()` methods invoke the `reload()`, which can also be called whenever suitable. 

```php
// ...Perform some operation on record...

// Later, force reload the record
$issue->reload();
```