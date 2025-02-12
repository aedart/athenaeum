# Changelog

TODO: Temporary changelog file for the upcoming major version `9.x`.

## [Unreleased]

### Added

* `float()` and `nextFloat()` methods in `NumericRandomizer` (_in the Utils package_). [#184](https://github.com/aedart/athenaeum/issues/184)
* `bytesFromString()` in `StringRandomizer` (_in the Utils package_). [#185](https://github.com/aedart/athenaeum/issues/185)
* `Json::isValid()` now accepts `$depth` and `$options` parameters.

### Changed

**Breaking Changes**

* Minimum required PHP version changed to `v8.3`.
* Adapted CI environment to test PHP `v8.3` and `v8.4`.

**Non-breaking Changes**

* Now using native `json_validate()`, in `\Aedart\Utils\Json::isValid`. [#120](https://github.com/aedart/athenaeum/issues/120).
* "Split Packages" GitHub workflow no longer triggered in pull requests.

### Fixed

* Fix [implicitly nullable parameter declarations](https://php.watch/versions/8.4/implicitly-marking-parameter-type-nullable-deprecated), throughout various components (_deprecated from PHP 8.4_).
* Fix passing `E_USER_ERROR` as the error_level for `trigger_error()`, in core application tests (_deprecated from PHP 8.4_).

### Removed

* `\Aedart\Auth\Fortify\Actions\RehashPasswordIfNeeded` (_was deprecated in Athenaeum `v8.x`_). [#182](https://github.com/aedart/athenaeum/issues/182).
* `\Aedart\Auth\Fortify\Events\PasswordWasRehashed` (_was deprecated in Athenaeum `v8.x`_). [#182](https://github.com/aedart/athenaeum/issues/182).