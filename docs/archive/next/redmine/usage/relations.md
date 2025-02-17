---
description: Relations
sidebarDepth: 0
---

# Relations

Many of the [predefined resources](../resources) offer ways to obtain related resources, via custom relations.
As an example, the `Issue` resource is related to many other kinds of resources. You can obtain them, per record, by invoking their corresponding methods:

```php
// Obtain issue's tracker
$tracker = $issue->tracker()->fetch();

// Obtain issue's parent
$parent = $issue->parent()->fetch();

// Issue's project
$project = $issue->project()->fetch();

// ...etc
```

## Apply filters

You may also specify filters on the relations, before fetching.

```php
use Aedart\Contracts\Http\Clients\Requests\Builder;

$children = $issue
    ->children()
    ->filter(function(Builder $request) {
        return $reqeust
                    ->where('subproject_id', 1234)
                    ->where('status_id', '*');
    })
    ->fetch();
```

## Onward

For more information about supported relations, please review each predefined resource's relation methods (_in the source code_).

