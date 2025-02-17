---
description: Athenaeum Release Notes
sidebarDepth: 0
---

# Release Notes

[[toc]]

## Support Policy

Athenaeum attempts to follow a release cycle that matches closely to that of [Laravel](https://laravel.com/docs/11.x/releases).
However, due to limited amount of project maintainers, no guarantees can be provided. 

| Version | PHP         | Laravel | Release              | Security Fixes Until |
|---------|-------------|---------|----------------------|----------------------|
| `10.x`  | `8.4 - ?`   | `v13.x` | _~1st Quarter 2026_  | _TBD_                |
| `9.x`*  | `8.3 - 8.4` | `v12.x` | _~1st Quarter 2025_  | February 2026        |
| `8.x`   | `8.2 - 8.3` | `v11.x` | Match 18th, 2024     | February 2025        |
| `7.x`   | `8.1 - 8.2` | `v10.x` | February 16th, 2023  | March 2024           |
| `6.x`   | `8.0 - 8.1` | `v9.x`  | April 5th, 2022      | February 2023        |
| `< 6.x` | _-_         | _-_     | _See `CHANGELOG.md`_ | _N/A_                |

_*: current supported version._

_TBD: "To be decided"._

## `v9.x` Highlights

These are the highlights of the latest major version of Athenaeum.

### PHP `v8.3` and Laravel `v12.x`

PHP version `v8.3` is now the minimum required version for Athenaeum.
[Laravel `v12.x`](https://laravel.com/docs/12.x/releases) packages are now used.

### Deprecated "Aware-of" Properties

The ["aware-of" properties](support/properties/available-helpers.md) have been deprecated. These have served their purpose in the past, but are now no longer
relevant. The components will be removed in the next major version. There are no plans to offer any alternatives.

## Changelog

Make sure to read the [changelog](https://github.com/aedart/athenaeum/blob/master/CHANGELOG.md) for additional information about the latest release, new features, changes and bug fixes. 
