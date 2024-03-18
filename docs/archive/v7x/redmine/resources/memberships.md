---
description: Working with project memberships
sidebarDepth: 0
---

# Project Memberships

As you might know, you are only able to assign an issue to a user or a group, if that user or group is member of the project in which the issue has been assigned to.
This section briefly highlights how to add or change project memberships.

## Add user membership

Given you already have an existing project and must add a new user as a member of the project, you can use the `addUserMember()` method.
The prerequisite, however, is that you also know the [role](https://www.redmine.org/projects/redmine/wiki/Rest_Roles) that user must be given.

```php
use Aedart\Redmine\Project;
use Aedart\Redmine\Role;
use Aedart\Redmine\User;

// Obtain user and role by ids
$user = User::findOrFail(1234);
$reviewer = Role::findOrFail(5);

// Find project by identifier
$project = Project::findOrFail('deus-ex');

// Add user as member of project
$membership = $project->addUserMember($user, [ $reviewer->id() ]);
```

## Add group membership

A similar approach is true, for addtion a group of users as project members.

```php
use Aedart\Redmine\Project;
use Aedart\Redmine\Role;
use Aedart\Redmine\Group;

// Obtain group and role...
$group = User::findOrFail(1234);
$reviewer = Role::findOrFail(5);

// Find project by identifier
$project = Project::findOrFail('deus-ex');

// Add group as member of project
$membership = $project->addGroupMember($user, [ $reviewer->id() ]);
```

## Get project members

To obtain a list of project members, use the `members()` relation method, on a given project.

```php
$members = $projet
    ->members()
    ->fetch();
```

## Remove a member

Invoke the `delete()` on the membership instance, when you wish to remove it from a project.

```php
$member->delete();
```

## Distinguish between user and group member

The `ProjectMembership` resource offers a few utilities that allow you to distinguish whether the membership is for a user or a group of users.

```php
if ($membership->isUserMembership()) {
    $user = $membership->user()->fetch()
    
    // ...do something with user membership
}

// ...Or 
if ($membership->isGroupMembership()) {
    $group = $membership->group()->fetch();
    
    // ...do something with group membership
}
```