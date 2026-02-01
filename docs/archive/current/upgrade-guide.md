---
description: Athenaeum Packages Upgrade Guide
sidebarDepth: 1
---

# Upgrade Guide

## From version 9.x to 10.x

[[TOC]]

### PHP version `8.4` required

You need PHP `v8.4` or higher to run Athenaeum packages.

**Note**: _PHP `v8.5` is supported!_

### Laravel `v13.x`

Please read Laravel's [upgrade guide](https://laravel.com/docs/13.x/upgrade), before continuing here.

### `Paths` Container now inherits from `ArrayDto`

The `Paths` container now inherits from `ArrayDto`. It no longer depends on the deprecated / removed "Aware-of" components.
All mutator methods (_setters_) have been removed. If you wish to manually set a directory path, you must do so by setting the property's value directly

**_:x: previously_**

```php
use Aedart\Core\Helpers\Paths;

$paths = new Paths();
$paths->setConfigPath(getcwd() . DIRECTORY_SEPARATOR . 'environments');

```

**_:heavy_check_mark: Now_**

```php
use Aedart\Core\Helpers\Paths;

$paths = new Paths();
$paths->configPath = getcwd() . DIRECTORY_SEPARATOR . 'environments';
```

## Onward

More extensive details can be found in the [changelog](https://github.com/aedart/athenaeum/blob/master/CHANGELOG.md).
