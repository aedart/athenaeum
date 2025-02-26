---
description: Working with Enumerations
sidebarDepth: 0
---

# Enumerations

Redmine offers a few enumeration resources, which are not editable via the API. These can be listed via the `list()` or `fetchMultiple()` methods.

**Note**: _Redmine ignores pagination requests, for enumeration resources!_

```php
use Aedart\Redmine\DocumentCategory;

$Categories = DocumentCategory::list();

// ...or
$categories = DocumentCategory::fetchMultiple();
```

The following resources are of the type enumeration:


### Document Categories

```php 
use Aedart\Redmine\DocumentCategory;
```

### Issue Priorities

```php 
use Aedart\Redmine\IssuePriority;
```

### Time Entry Activities

```php 
use Aedart\Redmine\TimeEntryActivity;
```