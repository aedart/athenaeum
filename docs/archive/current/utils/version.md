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

### Version file

_**Available since** `v6.1.x`_

By default, the `application()` method will return the root package's version, obtained via composer.
If this does not work for you, then you can choose to specify a "version file" as argument.

**Version file**
```txt
2.1.3@8476f2363a55f7d507553d46659c09a4c2b7ea0a
```

**Version from file**
```php
$version = Version::application('/path/to/version.txt');
```

The Utils package also comes with an example "build version" executable, which you could use as inspiration for building your own version file automatically.
The executable uses Git to obtain the latest version.
Please review the source code of `Utils/bin/build-version` for more information.

## Alternatives

You can also use [`jean85/pretty-package-versions`](https://packagist.org/packages/jean85/pretty-package-versions) or [Composer's runtime utilities](https://getcomposer.org/doc/07-runtime.md), to obtain version information for installed packages.
