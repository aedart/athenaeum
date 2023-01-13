---
description: Athenaeum Packages Upgrade Guide
sidebarDepth: 1
---

# Upgrade Guide

## From version 6.x to 7.x.

[[TOC]]

### PHP version `8.1` required

You need PHP `v8.1` or higher to run Athenaeum packages.

**Note**: _PHP `v8.2` is supported!_

### Laravel `v10.x`

Please read Laravel's [upgrade guide](https://laravel.com/docs/10.x/upgrade), before continuing here.

### Removed `SearchProcessor::language()`

The deprecated `\Aedart\Filters\Processors\SearchProcessor::language()` method has been removed. This features didn't work as intended.
No replacement has been implemented.

### Removed `Str::tree()`

`\Aedart\Utils\Str::tree()` was deprecated in `v6.4`. It has been replaced by `\Aedart\Utils\Arr::tree()`.

## Onward

More extensive details can be found in the [changelog](https://github.com/aedart/athenaeum/blob/master/CHANGELOG.md).
