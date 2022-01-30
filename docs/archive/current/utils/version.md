---
description: About the Version Utility
sidebarDepth: 0
---

# Version

The `Version` utility is able to determine if a version is available for an installed package and obtain it.

[[TOC]]

## `package()`

Returns the version of the given installed package.

`\Aedart\Contracts\Utils\Packages\Exceptions\PackageVersionException` is thrown if the given package is not installed or unable to find version information.

```php
use Aedart\Utils\Version;

$version = Version::package('aedart/athenaeum-utils');

echo (string) $version; // E.g. 6.0.0 
```

## `hasFor()`

Determine if a version is available for the given installed package.

If the package isn't installed, the method will simply return `false`.

```php
$hasVersion = Version::hasFor('aedart/athenaeum-utils'); 
```

## `application()`

The `application()` method returns the root package's version (_your application_).

```php
$version = Version::application(); 
```

## Alternatives

You can also use [`jean85/pretty-package-versions`](https://packagist.org/packages/jean85/pretty-package-versions) or [Composer's runtime utilities](https://getcomposer.org/doc/07-runtime.md), to obtain version information for installed packages.
