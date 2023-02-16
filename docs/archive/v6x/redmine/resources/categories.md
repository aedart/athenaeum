---
description: Working issue categories
sidebarDepth: 0
---

# Issue Categories

[Issue Categories](https://www.redmine.org/projects/redmine/wiki/Rest_IssueCategories) are also strictly tight to a project.
Therefore, when you wish to create new categories, you must obtain the desired project.

## Creating new category

```php
$category = $project->createIssueCategory([
    'name' => 'Business Goals'
]);
```

## Assign user

You may also set or change the user that should be assigned to an issue, which is created with a given category.

```php
use Aedart\Redmine\User;

$user = User::findOrFail(1234);

$category->update([
    'assigned_to' => $user->id() 
]);
```

**Note**: _Only new issues created with given category will have the user assigned by default. Existing issues are not updated!_

## Remove category

Simply invoke the `delete()` method, when you wish to remove a category from a project's available categories.

```php
$category->delete();
```

## Obtain project's issue categories

```php
$categories = $project
    ->issueCategories()
    ->fetch();
```