---
description: Predefined Resources
sidebarDepth: 0
---

# Predefined Resources

In this section you will find some information about the predefined "resources".
Where it is appropriate, custom functionality is explained in detail. However, this documentation is not exhaustive and not all resources are covered.
Please review the source for code for additional information.

## Make you own Resource

Despite this package's intent to provide as much flexibility as possible, when working with Redmine's API, it will certainly not cover every use-case.
You are therefore encouraged to either extend the existing resources or simply create your own.

### Extending Predefined

```php
use Aedart\Redmine\Issue as BaseIssue;

class Issue extends BaseIssue
{
    // ... add your own custom logic 
}
```

### Create new Resource

Should you wish to create an entirely new type of Resource, then you can choose to extend the `\Aedart\Redmine\RedmineResource` abstraction:

```php
use Aedart\Redmine\RedmineApiResource;
use Aedart\Contracts\Redmine\Listable,
use Aedart\Contracts\Redmine\Creatable,
use Aedart\Contracts\Redmine\Updatable,
use Aedart\Contracts\Redmine\Deletable

class MyCustomResource extends RedmineApiResource implements 
    Listable,
    Creatable,
    Updatable,
    Deletable
{
    protected array $allowed = [
        'id' => 'int',
        'name' => 'string'
    ];

    /**
     * @inheritDoc
     */
    public function resourceName(): string
    {
        return 'custom-resource';
    }
    
    // ... add your own custom logic 
}
```

Please review [Array DTO](../../dto/array) documentation to gain an understanding of how to specify `$allowed` properties for a resource. 