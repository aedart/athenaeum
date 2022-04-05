---
description: Working with project versions
sidebarDepth: 0
---

# Versions (Milestones)

Versions (_or milestones_) are tightly related to a project.
Please review [Redmine's documentation](https://www.redmine.org/projects/redmine/wiki/Rest_Versions), before proceeding here.

## Create new version

You can use the `createVersion()` method on a project instance, when you wish to add a new project version.

```php
use Aedart\Redmine\Version;

$version = $project->createVersion([
    'name' => '1.0.0'
    'description' => 'First major version',
    'due_date' => '2025-01-10',
    'status' => Version::STATUS_LOCKED
]);
```

### Shared state of version

The `sharing` property in the `Version` resource determines how it must be shared with other projects.
By default, a version is not shared with any other projects (`Version::SHARED_WITH_NONE`).
The resource contains a few predefined constants with possible values for the share state.

```php
use Aedart\Redmine\Version;

$version = $project->createVersion([
    'name' => '1.0.0',
    'sharing' => Version::SHARED_WITH_PROJECT_HIERARCHY
]);

// ...Or when updating a version
$version->update([
    'sharing' => Version::SHARED_WITH_PROJECT_TREE
]);
```

## Obtain versions

Use the `versions()` relation method to fetch a project's available versions.

```php
$versions = $project
    ->versions()
    ->fetch();
```

### Issues assigned to version

Once you have obtained one or more desired versions, you can use it to obtain issues that have been assigned to a particular version.

```php
 $issues = $version
    ->issues()
    ->limit(15)
    ->offset(16)
    ->fetch();
```

## Remove a version

Similar to other resources, you can simply invoke `delete()`, to remove a version from a project.

```php
$version->delete();
```