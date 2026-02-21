# Changelog `v10.x`

Temporary changelog for `v10.x` series.

## [Unreleased]

### Added

* `Formatter` components that is responsible for formatting original and changed model data (_Audit Trail package_).
* `LegacyRecordFormatter` (_deprecated_) for compatibility with current audit trail record formatting (_Audit Trail package_).
* `withoutRecording()` util method to perform an operation without recording model's changes, in `\Aedart\Audit\Concerns\ChangeRecording` (_Audit Trail package_).
* `performChange()` util method that allows setting the next audit trail message, when performing changes, in `\Aedart\Audit\Concerns\ChangeRecording` (_Audit Trail package_).
* `isSluggable()` util in `helpers/models.php` (_Database package_).
* `Arguments` and `Callback` concerns (_Utils package_).

### Changed

**Breaking Changes**

* The `Paths` container has been redesigned to inherit from `ArrayDto`. It no longer depends on the removed "Aware-of" components. (_Core package_). [#211](https://github.com/aedart/athenaeum/issues/211).
* Audit Trail Record formatting is now applied via new `Formatter`, performed via `\Aedart\Audit\Events\Concerns\EventData::format()` (_Audit Trail package_).
* Moved `formatDatetime()` from `\Aedart\Audit\Observers\Concerns\ModelAttributes` to `\Aedart\Audit\Events\Concerns\EventData` (_Audit Trail package_).

**Non-breaking Changes**

* `\Aedart\Audit\Helpers\Callback` now supports custom arguments to be passed on to the provided callback (_Audit Trail package_).
* Improved PHPDoc for `AuditTrailConfig` concern (_Audit Trail package_).
* Improved documentation examples for Audit Trail package.
* `Invoker` util has been refactored, its arguments and callback methods have been extracted into its own traits (_Utils package_).
* Removed PHPUnit annotations from tests. [#233](https://github.com/aedart/athenaeum/issues/233).
* Changed event triggers pull requests to "opened", "reopened", and "ready_for_review", and enabled concurrency check (_GitHub actions_). [#241](https://github.com/aedart/athenaeum/issues/241).
* `RequestMustBeJson` middleware has been refactored to use a static array of target HTTP methods (_Http Api package_).
* `RemoveResponsePayload` middleware now uses a static array of truthy values (_Http Api package_).
* Improved `resolveContent()` method in `GenericGenerator` (_ETags package_).
* Improved PHPDoc for `callable` parameters (_ETags and Http Api packages_).

### Fixed

* N/A

### Removed

* "Aware-of" components defined in `Aedart\Contracts\Support\Properties` and `Aedart\Support\Properties` (_was deprecated in Athenaeum `v9.x`_). [#210](https://github.com/aedart/athenaeum/issues/210).
* `properties.php` (_aware-of generator configuration file, in the root of Athenaeum_) (_was deprecated in Athenaeum `v9.x`_). [#210](https://github.com/aedart/athenaeum/issues/210).
* `resources/athenaeum` templates (_for aware-of components_), in `Support` package (_was deprecated in Athenaeum `v9.x`_). [#210](https://github.com/aedart/athenaeum/issues/210).

### Deprecated

* `\Aedart\Audit\Observers\Concerns\ModelAttributes`, replaced by `Formatter` components (_Audit Trail package_).
* `\Aedart\Audit\Formatters\LegacyRecordFormatter`, replaced by `\Aedart\Audit\Formatters\DefaultRecordFormatter` (_Audit Trail package_).
* `\Aedart\Audit\Concerns\ChangeRecording::$hiddenInAuditTrail`, replaced by `Formatter` components (_Audit Trail package_). 
* `\Aedart\Audit\Concerns\ChangeRecording::originalData`, replaced by `Formatter` components (_Audit Trail package_). 
* `\Aedart\Audit\Concerns\ChangeRecording::formatOriginalData`, replaced by `Formatter` components (_Audit Trail package_). 
* `\Aedart\Audit\Concerns\ChangeRecording::changedData`, replaced by `Formatter` components (_Audit Trail package_). 
* `\Aedart\Audit\Concerns\ChangeRecording::formatChangedData`, replaced by `Formatter` components (_Audit Trail package_). 
* `\Aedart\Audit\Concerns\ChangeRecording::filterAuditData`, replaced by `Formatter` components (_Audit Trail package_). 
* `\Aedart\Audit\Concerns\ChangeRecording::getHiddenForAudit`, replaced by `Formatter` components (_Audit Trail package_). 
* `\Aedart\Audit\Concerns\ChangeRecording::makeHiddenForAudit`, replaced by `Formatter` components (_Audit Trail package_). 
* `\Aedart\Audit\Concerns\ChangeRecording::attributesToHideForAudit`, replaced by `Formatter` components (_Audit Trail package_). 
* `\Aedart\Audit\Concerns\ChangeRecording::auditTimestampAttributes`, replaced by `Formatter` components (_Audit Trail package_). 
* `\Aedart\Audit\Concerns\ChangeRecording::shouldOmitDataFor`, replaced by `Formatter` components (_Audit Trail package_). 
* `\Aedart\Audit\Concerns\ChangeRecording::getAuditTrailMessage`, replaced by `Formatter` components (_Audit Trail package_). 
* `\Aedart\Audit\Concerns\ChangeRecording::$hiddenInAuditTrail`, replaced by `Formatter` components (_Audit Trail package_).