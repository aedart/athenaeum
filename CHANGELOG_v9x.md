# Changelog

TODO: Temporary changelog file for the upcoming major version `9.x`.

## [Unreleased]

### Added

* `float()` and `nextFloat()` methods in `NumericRandomizer` (_in the Utils package_). [#184](https://github.com/aedart/athenaeum/issues/184)
* `bytesFromString()` in `StringRandomizer` (_in the Utils package_). [#185](https://github.com/aedart/athenaeum/issues/185)
* `Json::isValid()` now accepts `$depth` and `$options` parameters.
* Configuration for `composer-bin-plugin` (_in root `composer.json`_).

### Changed

**Breaking Changes**

* Minimum required PHP version changed to `v8.3`.
* Adapted CI environment to test PHP `v8.3` and `v8.4`.
* Upgraded to use PHPStan `v2.x` [#200](https://github.com/aedart/athenaeum/issues/200).
* Replaced `yosymfony/toml` with `devium/toml` as supported toml parser (_affected component `\Aedart\Config\Parsers\Files\Toml`_). [#213](https://github.com/aedart/athenaeum/issues/213).
* `array` return type for various implementation of Laravel's `toArray()` method (_inherited from `\Illuminate\Contracts\Support\Arrayable`_).

**Non-breaking Changes**

* Now using native `json_validate()`, in `\Aedart\Utils\Json::isValid`. [#120](https://github.com/aedart/athenaeum/issues/120).
* Upgraded to use `shrikeh/teapot` `v3.x`.
* "Split Packages" GitHub workflow no longer triggered in pull requests.
* Class constants now have [types](https://php.watch/versions/8.3/typed-constants) declared.
* `\Aedart\Console\Commands\PirateTalkCommand` now uses `\Aedart\Utils\Arr::randomizer()->value()` to pick random sentence.

### Fixed

* Fix [implicitly nullable parameter declarations](https://php.watch/versions/8.4/implicitly-marking-parameter-type-nullable-deprecated), throughout various components (_deprecated from PHP 8.4_).
* Fix passing `E_USER_ERROR` as the error_level for `trigger_error()`, in core application tests (_deprecated from PHP 8.4_).

### Removed

* `\Aedart\Auth\Fortify\Actions\RehashPasswordIfNeeded` (_was deprecated in Athenaeum `v8.x`_). [#182](https://github.com/aedart/athenaeum/issues/182).
* `\Aedart\Auth\Fortify\Events\PasswordWasRehashed` (_was deprecated in Athenaeum `v8.x`_). [#182](https://github.com/aedart/athenaeum/issues/182).
* `\Aedart\Utils\Arr::randomElement()` (_was deprecated in Athenaeum `v8.x`_). Replaced by `\Aedart\Utils\Arr::randomizer()->value()`.
* `\Aedart\Utils\Math::randomInt()` (_was deprecated in Athenaeum `v8.x`_). Replaced by `\Aedart\Utils\Math::randomizer()->int()`.

### Deprecated

* All "aware-of" components defined in `Aedart\Contracts\Support\Properties` and `Aedart\Support\Properties`. These will be removed in the next major version.
* `properties.php` (_aware-of generator configuration file, in the root of Athenaeum_). Will be removed it the next major version.
* `resources/athenaeum` templates (_for aware-of components_), in `Support` package. These will be removed it the next major version. 