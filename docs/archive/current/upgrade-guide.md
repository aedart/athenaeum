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

### Onward

You can review other changes in the [changelog](https://github.com/aedart/athenaeum/blob/master/CHANGELOG.md).
