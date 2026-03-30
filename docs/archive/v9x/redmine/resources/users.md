---
description: Working with users
sidebarDepth: 0
---

# Users

The available `User` resource supports full CRUD operations. This sections highlights a few important concepts.   

## Creating new user

When you create a new user, it's important that that all required properties are set.
See [Redmine's docs](https://www.redmine.org/projects/redmine/wiki/Rest_Users) for additional details.

```php
use Aedart\Redmine\User;

$user = User::create([
    'login' => 'jimmy',
    'password' => '[...not shown...]',
    'firstname' => 'Jimmy',
    'lastname' => 'Thomsen',
    'mail' => 'jimmy@example.org'
]);
```

## Change user's status

Set the `status` property, when you wish to change a user's status.

```php
$user->update([
    'status' => User::STATUS_LOCKED
]);
```

## Change notifications

The `mail_notification` can be specified, when you wish to set or change the user's email notification settings.

```php
use Aedart\Redmine\User;

$user->update([
    'mail_notification' => User::NONE_MAIL_NOTIFICATION
]);
```

## User's issues

The `User` resource offers a few ways to obtain issues that a user has authored or is directly assigned to.

```php
// Issues user has created
$authored = $user
    ->authoredIssues()
    ->fetch();

// ...Or issues assigned to user
$assigned = $user
    ->assignedIssues()
    ->fetch();
```