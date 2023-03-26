---
description: Find a single resource
sidebarDepth: 0
---

# Find

Given that you know a resource's identifier, you can use the `find()` method to find a single resource. 

```php
$issue = Issue::find(1234); // Found issue or null
```

## Find or fail

You can use the `findOrFail()`, if you wish an exception to be thrown if the requested resource does not exist.

```php
use Aedart\Redmine\Exceptions\NotFound;

try {
    $issue = Issue::findOrFail(1234);
} catch (NotFound $e) {
    // ...do something when not found...
}
```

## Associated Data

Both `find()` and `findOrFail()` methods support a list of "associated data" identifiers, as their second argument.

```php
$issue = Issue::findOrFail(1234, [ 'relations' ]); // Issue with "relations"
```

