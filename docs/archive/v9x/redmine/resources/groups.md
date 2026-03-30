---
description: Redmine User Groups
sidebarDepth: 0
---

# User Groups

Redmine allows assigning issues to either a user or a group of users. The distinction can be very difficult to see in Redmine's API, if at all possible.
This package does attempt to automatically resolve an assigned user or group, for issues - when requested. It does, however, come at the cost of addition requests. 

In this section, you will find a brief guide on working with user groups.

## Creating new Group

When creating a new group, you can immediately specify the users that must be part of the group, by setting the `user_ids` property.

```php
use Aedart\Redmine\Group;

$group = Group::create([
    'name' => 'Senior Developers',
    'user_ids' => [ 1234, 665, 22]
]);
```

## Adding users to existing group

```php
use Aedart\Redmine\user;

$user  = User::findOrFail(32); 

$group = Group::findOrFail(40);
$group->adduser($user);
```

The `addUser()` accepts multiple types of values, such as a user id, instance or reference (_a nested dto object_).

```php
// Add user with id 40 to group...
$group->adduser(40);
```

## Removing users from group

Likewise, you can use the `removeUser()` to remove a user from an existing group.

```php
$group->removeUser($user);

// ...Or via user's id
$group->removeUser(40);
```

## Issues assigned to group

Given that you have obtained a group and would like to know all issues that are assigned to that group, then you can use the `assignedIssues()` relations method to obtain a paginated list of issues.

```php
$issues = $group
    ->assignedIssues()
    ->limit(50)
    ->offset(51)
    ->fetch();
```