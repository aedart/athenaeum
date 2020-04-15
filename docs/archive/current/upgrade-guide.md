---
description: Athenaeum Packages Upgrade Guide
sidebarDepth: 1
---

# Upgrade Guide

## From version 3.x to 4.x.

[[TOC]]

### Laravel `v7.6.x`

Upgraded the `illuminate/*` packages to version `^7.6.x`.
Please review Laravel's [upgrade guide](https://laravel.com/docs/7.x/upgrade) for additional information.

### Symfony `v5.x`

Upgraded the `symfony/*` packages to version `^5.x`.
Please review Symfony's [upgrade guide](https://symfony.com/doc/current/setup/upgrade_major.html) for additional information.

### Http `Client` Redesigned

On the surface, the Http `Client` remains almost the same. Using all the request methods still work as in previous version.
However, when using the fluent methods, such as `withHeaders()`, a Http Query `Builder` is returned instead of the Http `Client`

```php
// Version 3.x - \Aedart\Contracts\Http\Clients\Client returned
$client = $client->withHeaders([ 'Content-Type' => 'application/json' ]);

// Now (version 4.x) - \Aedart\Contracts\Http\Clients\Requests\Builder returned
$builder = $client->withHeaders([ 'Content-Type' => 'application/json' ]); 
```

The `Builder` is still connected the `Client` instance, which will continue to allow method chaining.

#### Custom Http Client

If you created your own custom Http `Client`, based on Athenaeum `v3.x`, then you are unfortunately forced to migrate your changes into a new custom client. 
Chances are very high that your client will not work, due to the heavy redesign of the existing client class.

### IoC vs. `app` binding

`\Aedart\Container\IoC` no longer highjacks Laravel's `app` binding automatically, when `getInstance()` is invoked.
This was used to get some of Laravel's components to work outside the scope of a Laravel application.
Yet, this was a "hack" that potentially could lead to conflicted with Laravel's `Application` class, which was never intended.

If you rely on this behaviour, e.g. in your tests, then you now need to invoke `registerAsApplication()` manually, in order to register the `IoC` as the `app` binding.

```php
// Version 3.x - `app` binding highjacked!
$ioc = \Aedart\Container\IoC::getInstance();

// Now (version 4.x) - you must manually declare that you wish 
// to register IoC as the `app` binding.
$ioc = \Aedart\Container\IoC::getInstance();
$ioc->registerAsApplication();
```

::: warning
You should NOT invoke `registerAsApplication()` if you are using the `IoC` component within a Laravel application.
It will highjack the `app` binding, which will cause your application to behave unfavourable.
:::

### Deprecated Dto abstractions

`\Aedart\Dto` abstraction has been deprecated and will be removed in next major version.
It has been replaced by `\Aedart\Dto\Dto`.

`\Aedart\ArrayDto` abstraction has also been deprecated.
It's replaced by `\Aedart\Dto\ArrayDto`.

### Deprecated `Mixed` Aware-of Helpers

All Aware-of helpers found within the `Aedart\Support\Properties\Mixed` are now deprecated. 
The term `Mixed` has been a [soft-reserved keyword](https://www.php.net/manual/en/reserved.other-reserved-words.php) since PHP `v7.0`, and there is a chance that PHP might use this keyword in the future.
These helper will be removed in the next major version.
The equivalent is true for the corresponding interfaces, found in the `Aedart\Contracts\Support\Properties\Mixed` namespace.

You can find replacements within the `Aedart\Support\Properties\Mixes` and `Aedart\Contracts\Support\Properties\Mixes` namespaces.

```php
// Version 3.x - deprecated Aware-of Helpers
use Aedart\Contracts\Support\Properties\Mixed\HtmlAware;
use Aedart\Support\Properties\Mixed\HtmlTrait;

// Now (version 4.x)
use Aedart\Contracts\Support\Properties\Mixes\HtmlAware;
use Aedart\Support\Properties\Mixes\HtmlTrait; 
```

### Deprecated Scaffold Commands

`\Aedart\Console\CommandBase`, `\Aedart\Console\AwareOfScaffoldCommand` and `\Aedart\Console\CreateAwareOfCommand` have been deprecated.
These commands will be removed in next major version.
Replacements are available within the [Support package](./support).

The original commands are still available using the `athenaeum` console application.

### Testing Packages

[Codeception](https://github.com/Codeception/Codeception) and [Orchestra Testbench](https://github.com/orchestral/testbench) are now defined as dev-dependencies.
If you relied on these packages, then you need to manually require them in your `composer.json`.
This change will only affect you, if you continue to use the full `aedart/athenaeum` (_discouraged, you should use the individual packages instead_).

### Onward

You can review other changes in the [changelog](https://github.com/aedart/athenaeum/blob/master/CHANGELOG.md).
