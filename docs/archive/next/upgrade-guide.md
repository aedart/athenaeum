---
description: Athenaeum Packages Upgrade Guide
sidebarDepth: 1
---

# Upgrade Guide

## From version 8.x to 9.x

[[TOC]]

### PHP version `8.3` required

You need PHP `v8.3` or higher to run Athenaeum packages.

**Note**: _PHP `v8.4` is supported!_

### Laravel `v12.x`

Please read Laravel's [upgrade guide](https://laravel.com/docs/12.x/upgrade), before continuing here.

### TOML parser changed to `devium/toml`

The [configuration loader](./config/README.md) now requires [`devium/toml`](https://github.com/vanodevium/toml) for
parsing [toml](https://github.com/toml-lang/toml) files. Previously [`yosymfony/toml`](https://github.com/yosymfony/toml)
was required.

### Removed `Arr::randomElement()`

`\Aedart\Utils\Arr::randomElement()` was deprecated in `v8.x`. It has been replaced
by `\Aedart\Utils\Arr::randomizer()->value()`.

### Removed `Math::randomInt()`

`\Aedart\Utils\Math::randomInt()` was deprecated in `v8.x`. It has been replaced
by `\Aedart\Utils\Math::randomizer()->int()`.

## Onward

More extensive details can be found in the [changelog](https://github.com/aedart/athenaeum/blob/master/CHANGELOG.md).
