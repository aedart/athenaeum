---
description: Issue Trackers
sidebarDepth: 0
---

# Trackers

Similar to the [Role resource](./roles.md), [Redmine's API](https://www.redmine.org/projects/redmine/wiki/Rest_Trackers) only supports reading available issue trackers.
These can only be obtained as a list.

```php
use Aedart\Redmine\Tracker;

$trackers = Tracker::list();
```

**Note**: _The trackers API resource does not support pagination!_

## Issue's tracker

Despite the API limitations of only being available to list trackers, you can still obtain an individual tracker, by means of relations on an issue. 

```php
$tracker = $issue
    ->tracker()
    ->fetch();

// ...do something with issue's tracker...
$fields = $tracker->enabled_standard_fields;
```
