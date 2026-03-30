---
description: Supported Operations
sidebarDepth: 0
---

# Supported Operations

As previously mentioned, Redmine's API does have some limitations and inconsistencies. Sadly, this means that not all [predefined resources](../resources) are able to perform common CRUD operations.
If a resource does not support an operation, you might encounter the following exception:

```php
use Aedart\Contracts\Redmine\Exceptions\RedmineException;
```

## Listable, Creatable, Updatable...

You can review each of the predefined resource and determine whether they support common CRUD functionality or not, by reviewing the interfaces it inherits from.
For instance, the `Project` resources inherits from `Listable`, `Creatable`, `Updatable` and `Deletable`. This means that it has full support for CRUD operations.

```php
<?php

namespace Aedart\Redmine;

use Aedart\Contracts\Redmine\Creatable;
use Aedart\Contracts\Redmine\Deletable;
use Aedart\Contracts\Redmine\Listable;
use Aedart\Contracts\Redmine\ApiResource;
use Aedart\Contracts\Redmine\Updatable;

class Project extends RedmineApiResource implements
    Listable,
    Creatable,
    Updatable,
    Deletable
{
    // ...resource body not shown...
}
```
