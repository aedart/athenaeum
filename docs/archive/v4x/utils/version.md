---
description: About the Version Utility
sidebarDepth: 0
---

# Version

The `Version` utility is able to determine if a version is available for a installed package and obtain it.
Behind the scene, ["pretty-package-versions"](https://packagist.org/packages/jean85/pretty-package-versions) is being used.

[[TOC]]

## `hasFor()`

Determine if a version is available for the given installed package.

If the package isn't installed, the method will simply return `false`.

```php
use Aedart\Utils\Version;

$hasVersion = Version::hasFor('aedart/athenaeum-utils'); 
```

## `package()`

Returns the version of the given installed package.

An `\OutOfBoundsException` is thrown if the given package is not installed.

```php
use Aedart\Utils\Version;

$version = Version::package('aedart/athenaeum-utils'); 
```

See ["pretty-package-versions"](https://packagist.org/packages/jean85/pretty-package-versions) for additional information. 
