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

### Removed "Aware-of" Components

The "aware-of" components that were located in `Aedart\Contracts\Support\Properties` and `Aedart\Support\Properties` have been removed.
They have been deprecated since `v9.x`. No replacements are offered!

If you depend on any of those components, please review the source code of previous versions of the Athenaeum Support package.

### Other Deprecated Components

Several other deprecated components have also been removed. Please review the `CHANGELOG.md` for additional details.

## Onward

More extensive details can be found in the [changelog](https://github.com/aedart/athenaeum/blob/master/CHANGELOG.md).
