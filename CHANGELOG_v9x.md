# Changelog

TODO: Temporary changelog file for the upcoming major version `9.x`.

## [Unreleased]

### Changed

**Breaking Changes**

* Minimum required PHP version changed to `v8.3`.
* Adapted CI environment to test PHP `v8.3` and `v8.4`.

**Non-breaking Changes**

* N/A


### Fixed

* Fix [implicitly nullable parameter declarations](https://php.watch/versions/8.4/implicitly-marking-parameter-type-nullable-deprecated), throughout various components (_deprecated from PHP 8.4_).
* Fix passing `E_USER_ERROR` as the error_level for `trigger_error()`, in core application tests (_deprecated from PHP 8.4_). 
