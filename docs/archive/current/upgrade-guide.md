---
description: Athenaeum Packages Upgrade Guide
sidebarDepth: 1
---

# Upgrade Guide

## From version 4.x to 5.x.

[[TOC]]

### Laravel `v8.x`

Upgraded the `illuminate/*` packages to version `^8.x`.
Please review Laravel's [upgrade guide](https://laravel.com/docs/8.x/upgrade) for additional information.

### Added `bootstrap()` in Console `Kernel`

As a result of upgrading to Laravel `v8.x`, a new `bootstrap()` method was added to the `\Aedart\Core\Console\Kernel` component.
The `runCore()` method now invokes the new bootstrap method.

This change only affects you, if a custom implementation of the Console `Kernel` is used.

### Response Expectations

The response expectations in Http `Client` have changed. They are now encapsulated in a `ResponseExpectation` instance.
This means that if you wish to obtain an expectation, you will no longer receive the original callback method. 

```php
// Before (version 4.x)
$containsUserId = function($status, $response) {
    // ... not shown
};

$expectations = $client 
            ->expect($containsUserId)
            ->getExpectations(); // [ $containsUserId ] Array with provided callable method.

var_dump($containsUserId === $expectations[0]); // true

// Now (version 5.x)
$expectations = $client 
            ->expect($containsUserId)
            ->getExpectations(); // [ ResponseExpectation ] Array with response expectation instance

var_dump($containsUserId === $expectations[0]); // false
var_dump($containsUserId === $expectations[0]->getExpectation()); // true
```

Please review `\Aedart\Contracts\Http\Clients\Responses\ResponseExpectation` for more details.

### Http Client Changes

Several changes have been made to the Http `Client` and it's request `Builder`.
These changes _should not_ affect you directly.
However, if you have custom implementation of the provided interfaces, then you may have to refactor parts of your code.
Review the source code and [changes made](https://github.com/aedart/athenaeum/compare) for additional information.

### Removed Deprecated Components

The following deprecated components have been removed:

* `Aedart\Dto` (_replaced by `Aedart\Dto\Dto`_).
* `Aedart\ArrayDto` (_replaced by `Aedart\Dto\ArrayDto`_).
* `Aedart\Console\CreateAwareOfCommand` (_replaced by `Aedart\Support\AwareOf\Console\CreateCommand`_).
* `Aedart\Console\CommandBase` (_replaced by `Aedart\Support\AwareOf\Console\CommandBase`_).
* `Aedart\Console\AwareOfScaffoldCommand` (_replaced by `Aedart\Support\AwareOf\Console\ScaffoldCommand`_).
* Removed all aware-of helpers in `Aedart\Support\Properties\Mixed\*` and `Aedart\Contracts\Support\Properties\Mixed\*` namespaces (_replaced by `Aedart\Support\Properties\Mixes\*` and `Aedart\Contracts\Support\Properties\Mixes\*`_).

### Onward

You can review other changes in the [changelog](https://github.com/aedart/athenaeum/blob/master/CHANGELOG.md).
