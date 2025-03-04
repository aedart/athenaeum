---
description: Athenaeum Release Notes
sidebarDepth: 0
---

# Release Notes

[[toc]]

## Support Policy

Athenaeum attempts to follow a release cycle that matches closely to that of [Laravel](https://laravel.com/docs/12.x/releases).
However, due to limited amount of project maintainers, no guarantees can be provided. 

| Version | PHP         | Laravel | Release              | Security Fixes Until |
|---------|-------------|---------|----------------------|----------------------|
| `10.x`  | `8.4 - ?`   | `v13.x` | _~1st Quarter 2026_  | _TBD_                |
| `9.x`*  | `8.3 - 8.4` | `v12.x` | March 4th, 2025      | February 2026        |
| `8.x`   | `8.2 - 8.3` | `v11.x` | March 18th, 2024     | February 2025        |
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

### Randomizer `float()`, `nextFloat()` and `bytesFromString()`

`NumericRandomizer` now supports generating random floats via [`float()`](./utils/math.md#float)
and [`nextFloat()`](./utils/math.md#nextfloat). Additionally, the `StringRandomizer` now offers a
[`bytesFromString()`](./utils/string.md#bytesfromstring) method.

### Environment File utility

The `EnvFile` can be used for replacing the value of an existing key, or appending a new key-value pair, in the
application's environment file.

See [Support package documentation](./support/env-file.md) for details.

### Redmine `v6.0.x` API 

The [Redmine Client](./redmine/README.md) now supports [Redmine `v6.0.x` API](https://www.redmine.org/projects/redmine/wiki/Rest_api). 

### Auth Exceptions and Responses

The Auth package has received a few new components, intended to be used in combination with for Laravel Fortify.
Among them are a few predefined exceptions and response helpers.

See [Auth Fortify documentation](./auth/fortify/README.md) for details.

### TOML version 1.0.0 Supported

The [configuration loader](./config/README.md) now supports [toml](https://github.com/toml-lang/toml) version `1.0.0` format.

Please see the [upgrade guide](./upgrade-guide.md) for details.

### Additional parameters for `Json::isValid()`  

The `Json::isValid()` now accepts `$depth` and `$options` as optional parameters.

See [documentation](./utils/json.md#validation) for details.

### Deprecation of "Aware-of" Properties

The ["aware-of" properties](support/properties/available-helpers.md) have been deprecated. These have served their purpose in the past, but are now no longer
relevant. The components will be removed in the next major version. There are no plans to offer any alternatives.

## Changelog

Make sure to read the [changelog](https://github.com/aedart/athenaeum/blob/master/CHANGELOG.md) for additional information about the latest release, new features, changes and bug fixes. 
