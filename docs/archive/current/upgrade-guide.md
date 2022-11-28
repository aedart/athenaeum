---
description: Athenaeum Packages Upgrade Guide
sidebarDepth: 1
---

# Upgrade Guide

## From version 5.x to 6.x.

[[TOC]]

### PHP version `8` required

You need PHP `v8.0.2` or higher to run Athenaeum packages.

**Note**: _PHP `v8.1` is supported!_

### Laravel `v9.x`

Since Athenaeum has upgraded to Laravel `v9.x`, you should read Laravel's [upgrade guide](https://laravel.com/docs/9.x/upgrade), before continuing here.

### Argument- and Return Types

Almost all components, throughout all packages, have their argument and return types changed. [Union Types](https://php.watch/versions/8.0/union-types) are now being used extensively, where appropriate.
This means that you will most likely experience breaking changes if:

* You implement an interface
* You extend a component

Some of these changes will be highlighted in this upgrade guide, yet there are too many to cover here.
Please make sure to _test your code_ before using any Athenaeum package in a production environment!

### Version util return type

The `\Aedart\Utils\Version` utility now returns `\Aedart\Contracts\Utils\Packages\Version` for it's `application()` and `package()` methods.

```php
// Previously
$version = Version::application(); // \Jean85\Version

// Now...
$version = Version::application(); // \Aedart\Contracts\Utils\Packages\Version
```

In addition, a `PackageVersionException` is now thrown from the `package()` method, if a version cannot be obtained.

```php
// Previously
Version::package('acme/unknown-package');
// OutOfBoundsException thrown

// Now...
Version::package('acme/unknown-package');
// \Aedart\Contracts\Utils\Packages\Exceptions\PackageVersionException thrown
```

See [#68](https://github.com/aedart/athenaeum/issues/68) for additional details.

### `populate()` now returns `static`

The `\Aedart\Contracts\Utils\Populatable::populate()` method new returns `static`.
This allows for a more fluent experience, when working with DTOs, e.g.

```php
// Previously
$person->populate([
    'name' => 'John Smith'
]);

$person->setAge(28);

// Now...
$person->populate([
    'name' => 'John Smith'
])->setAge(28);
```

If you have a custom implementation of `populate()`, then you must now ensure that the method returns.

```php
use Aedart\Contracts\Utils\Populatable;

class Person implements Populatable
{
    public function populate(array $data = []): static
    {
        // ...populate implementation not shown...
        
        // Make sure to return instance!
        return $this;
    }
}
```

### Listener option replaced, in Audit Trail package

The `listener` option found in `config/audit-trail.php` has been replaced by `subscriber`, which uses an [event subscriber](https://laravel.com/docs/9.x/events#event-subscribers) component instead.

```php
return [
    // ...previous not shown ...
    
    // 'listener' NO LONGER USED!
    'listener' => \Aedart\Audit\Listeners\RecordAuditTrailEntry::class,

    // Replacement
    'subscriber' => \Aedart\Audit\Subscribers\AuditTrailEventSubscriber::class,

    // ...remaining not shown ...
];
```

### RFC3339 used as default format

[RFC3339](https://datatracker.ietf.org/doc/html/rfc3339) is now set as the default `datetime_format` option for the Http Query Grammar Profiles, in `config/http-clients`.
_If you already have a datetime format specified in `config/http-clients.php`, then this change will not affect you._

### Language directory path in Core `Application`

The Core `Application` and `PathsContainer` now offer a `langPath()` method. This method has been added due to the addition and changes regarding language files in Laravel.
By default, if your application has not specified a custom language path, it will return a default path in the root of the project (_previously lang directory was located in `resources/lang`_).

```php
echo $application->langPath(); // lang
```

The application will ensure that if you still use `resources/lang`, then languages files will be read from there.
See [Laravel's upgrade guide](https://laravel.com/docs/9.x/upgrade#the-lang-directory) for details.

### Replaced `\DateTime` with `\DateTimeInterface`

Several "aware-of" helpers previously declared `\DateTime` as their value type, e.g. `\Aedart\Contracts\Support\Properties\Integers\DateAware`.
These have all been changed to accept `\DateTimeInterface` instead.

_This change can affect you if you have overwritten any getter, setter or default-value method, from the "aware-of" components._

### `$seed` can no longer be `null`

The `$seed` argument for `\Aedart\Utils\Math::applySeed()` no longer accepts `null` as value.

```php
// Previously
Math::applySeed(null); // Was allowed

// Now...
Math::applySeed(null); // NOT allowed!

// Use 0 instead, if needed!
Math::applySeed(0); // allowed
```

### Removed `MocksApplicationServices` from testing utilities

The `\Illuminate\Foundation\Testing\Concerns\MocksApplicationServices` helper has been deprecated by Laravel and therefore removed from `AthenaeumTestHelper` and `LaravelTestHelper` entirely.
If you rely on this component, then you are strongly encouraged to refactor your tests, as it will not be supported in future versions of Laravel.

## Onward

More extensive details can be found in the [changelog](https://github.com/aedart/athenaeum/blob/master/CHANGELOG.md).
