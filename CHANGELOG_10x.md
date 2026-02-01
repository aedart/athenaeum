# Changelog `v10.x`

Temporary changelog for `v10.x` series.

## [Unreleased]

### Added

* N/A

### Changed

**Breaking Changes**

* The `Paths` container has been redesigned to inherit from `ArrayDto`. It no longer depends on the removed "Aware-of" components. (_in the Core package_). [#211](https://github.com/aedart/athenaeum/issues/211). 

**Non-breaking Changes**

* Removed PHPUnit annotations from tests. [#233](https://github.com/aedart/athenaeum/issues/233).
* Changed event triggers pull requests to "opened", "reopened", and "ready_for_review" (_GitHub actions_). [#241](https://github.com/aedart/athenaeum/issues/241).

### Fixed

* N/A

### Removed

* "Aware-of" components defined in `Aedart\Contracts\Support\Properties` and `Aedart\Support\Properties` (_was deprecated in Athenaeum `v9.x`_). [#210](https://github.com/aedart/athenaeum/issues/210).
* `properties.php` (_aware-of generator configuration file, in the root of Athenaeum_) (_was deprecated in Athenaeum `v9.x`_). [#210](https://github.com/aedart/athenaeum/issues/210).
* `resources/athenaeum` templates (_for aware-of components_), in `Support` package (_was deprecated in Athenaeum `v9.x`_). [#210](https://github.com/aedart/athenaeum/issues/210).

### Deprecated

* N/A