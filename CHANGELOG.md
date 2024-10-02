# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [8.11.0] - 2024-10-02

### Changed

* Updated dependencies (_service update_).

### Fixed

* `DatabaseAdapter` fails when attempting to move or copy to the same destination as the source (_adapter now skips performing `move()` or `copy()`, if source and destination are the same_). [#195](https://github.com/aedart/athenaeum/issues/195).

## [8.10.0] - 2024-09-23

### Changed

* Updated dependencies (_service update_).

## [8.9.0] - 2024-09-04

### Changed

* Updated dependencies (_service update_).

### Fixed

* Incorrect `port` argument, in `BrowserTestCase` (_`--port` expected, but `port` was given as argument_).

## [8.8.0] - 2024-08-07

### Changed

* Updated dependencies (_service update_).

## [8.7.0] - 2024-07-22

### Changed

* Updated dependencies (_service update_).

## [8.6.0] - 2024-06-27

### Changed

* Updated dependencies (_service update_).

### Fixed

* Incorrect contents listing, due to missing separator affix in path (_in `DatabaseAdapter`_). [#193](https://github.com/aedart/athenaeum/issues/193).

## [8.5.0] - 2024-06-18

### Changed

* Updated dependencies (_service update_).

### Fixed

* Out-of-memory when attempting to detect mime-type of large file. [#191](https://github.com/aedart/athenaeum/pull/191).

## [8.4.0] - 2024-05-28

### Changed

* Updated dependencies (_service update_).
* `\Aedart\Tests\Integration\Flysystem\Db\Storage\StorageDiskTest::getEnvironmentSetUp()` now uses the default database connection. [#190](https://github.com/aedart/athenaeum/pull/190).

### Fixed

* `fclose()`: supplied resource is not a valid stream resource when attempting to copy a stream, in `DatabaseAdapter` (_psql connections were affected_). [#190](https://github.com/aedart/athenaeum/pull/190).
* `DatabaseAdapter::createDirectory()` fails when attempting to create directories that already exists (_mariadb connections were affected_). [#190](https://github.com/aedart/athenaeum/pull/190).
* Incorrect dummy file visibility when created, in `\Aedart\Tests\Integration\Flysystem\Db\Adapters\D0_FileVisibilityTest::canSetVisibilityForFile()` (_mariadb connection was affected_). [#190](https://github.com/aedart/athenaeum/pull/190).
* Incorrect test assertion of file contents, in `\Aedart\Tests\Integration\Flysystem\Db\Adapters\C0_WriteFilesTest::canUpdateFile()` (_psql connection was affected_). [#190](https://github.com/aedart/athenaeum/pull/190).

## [8.3.0] - 2024-05-07

### Changed

* Updated dependencies (_service update_).

## [8.2.0] - 2024-04-23

### Changed

* Updated dependencies (_service update_).

## [8.1.0] - 2024-04-07

### Added

* `@condorhero/vuepress-plugin-export-pdf-v2` package as dev dependency (_due to PDF export experiment of docs, in `packages.json`_).

### Changed

* Updated dependencies (_service update_).

### Fixed

* `Aedart\Streams\Stream::close()` not compatible with `Psr\Http\Message\StreamInterface::close(): void` (_happens when psr/http-message `v2.0` is required_). [#187](https://github.com/aedart/athenaeum/issues/187).

## [8.0.0] - 2024-03-18

### Added

* `\Aedart\Testing\Generators\MockTrait`, a replacement for the deprecated `MockTrait` in PHPUnit.
* `ISO8601_EXPANDED` in `\Aedart\Contracts\Utils\Dates\DateTimeFormats`. [#142](https://github.com/aedart/athenaeum/issues/142).
* `snapshot()` and `usage()` in `\Aedart\Utils\Memory`. [#104](https://github.com/aedart/athenaeum/issues/104).
* `randomizer()` in `\Aedart\Utils\Math`, `\Aedart\Utils\Arr` and `\Aedart\Utils\Str`. [#150](https://github.com/aedart/athenaeum/issues/150), [#151](https://github.com/aedart/athenaeum/issues/151).
* Randomizer `Factory` that is able to return either of the following `StringRandomizer`, `NumericRandomizer` or `ArrayRandomizer` (_adapters for PHP's native `Random\Randomizer`_), in `\Aedart\Utils\Random`. [#150](https://github.com/aedart/athenaeum/issues/150).
* `buffer()` method in `\Aedart\Contracts\Streams\Stream` interface. [#156](https://github.com/aedart/athenaeum/issues/156).
* `copyFrom()`, `openFileInfo()`, `openUploadedFile()` and `filename()` methods in `\Aedart\Contracts\Streams\FileStream` interface. [#156](https://github.com/aedart/athenaeum/issues/156).

### Changed

**Breaking Changes**

* Minimum required PHP version changed to `v8.2`.
* Adapted CI environment to test PHP `v8.2` and `v8.3`.
* Upgraded to use Laravel `v11.x` packages.
* Upgraded to use Symfony `v7.x` packages.
* Reworked `TraitTester` to no longer use deprecated features from PHPUnit. Now using `Mockery` to mock traits instead.
* Refactored `AlphaDashDot` and `SemanticVersion` to inherit from `BaseValidationRule`, in `\Aedart\Validation\Rules` (_previously inherited from deprecated `BaseRule`, which has been removed_). [#158](https://github.com/aedart/athenaeum/issues/158).
* Converted `RecordTypes` and `Visibility` interfaces to enums, in `\Aedart\Contracts\Flysystem\Db` (_contributed by [Trukes](https://github.com/Trukes)_). [#161](https://github.com/aedart/athenaeum/issues/161), [#162](https://github.com/aedart/athenaeum/pull/162/).
* `ValidatedApiRequest` no longer overwrites Laravel's "class based `after()` validation rules". [#168](https://github.com/aedart/athenaeum/issues/168), [#167](https://github.com/aedart/athenaeum/issues/167).
* `defaultScanner()` now returns `ClamAv` scanner (_previously returned `NullScanner`_), in `\Aedart\Antivirus\Manager`.

### Deprecated

* `\Aedart\Auth\Fortify\Actions\RehashPasswordIfNeeded` and `\Aedart\Auth\Fortify\Events\PasswordWasRehashed`. Password rehashing is now a default part of Laravel's [`\Illuminate\Contracts\Auth\UserProvider`](https://laravel.com/docs/11.x/upgrade#authentication).
* `\Aedart\Utils\Math::randomInt()` - replaced by `\Aedart\Utils\Math::randomizer()->int()`. [#150](https://github.com/aedart/athenaeum/issues/150).
* `\Aedart\Utils\Arr::randomElement()` - replaced by `\Aedart\Utils\Arr::randomizer()->value()`. [#150](https://github.com/aedart/athenaeum/issues/150).

### Fixed

* Missing return type for `\Aedart\Support\AwareOf\Console\CommandBase::execute` (_after upgrade to Symfony `v7.x`_).
* `RehashPasswordIfNeededTest` fails due to enabled auto-rehash password feature in Laravel.
* Incorrect quotes for expected SQL, in `BelongsToFilterTest`, `SearchFilterTest`, `SortFilterTest`, `SearchProcessorTest`, and `RelationsFilteringTest` (_caused by updates to SQLite driver in Laravel `v11`_).  
* `LaravelExceptionHandler::render()` response violates interface, in `\Aedart\Core` (_A new `AdaptedExceptionHandler` interface has been added which overwrites `render()` return to `void`_). [#153](https://github.com/aedart/athenaeum/issues/153).

### Removed

* `\Aedart\Http\Api\Requests\ValidatedApiRequest::after` (_was deprecated in `v7.12.0`_).
* `\Aedart\Filters\Query\Filters\Fields\BaseFieldFilter::datetimeRangeComparison` (_was deprecated in `v7.11.3`_).
* `\Aedart\Audit\Models\Concerns\AuditTrailConfiguration` (_was deprecated in `v7.4`_).
* `\Aedart\Audit\Traits\HasAuditTrail` (_was deprecated in `v7.0`_).
* `\Aedart\Audit\Traits\RecordsChanges` (_was deprecated in `v7.0`_).
* `\Aedart\Contracts\Validation\FailedState` (_was deprecated in `v7.4`_).
* `\Aedart\Validation\Rules\BaseRule` (_was deprecated in `v7.4`_).
* `\Aedart\Validation\Rules\Concerns\AthenaeumRule` (_was deprecated in `v7.4`_).
* `\Aedart\Validation\Rules\Concerns\Attribute` (_was deprecated in `v7.4`_).
* `\Aedart\Validation\Rules\Concerns\Translations` (_was deprecated in `v7.4`_).
* `\Aedart\Validation\Rules\Concerns\ValidationFailure` (_was deprecated in `v7.4`_).
* `\Aedart\Tests\Integration\Validation\Concerns\ValidationFailureTest` (_no longer required_).

## [7.33.0] - 2024-03-13

### Changed

* Updated dependencies (_last expected service updated in the `v7.x` series._)

## [7.32.0] - 2024-02-29

### Changed

* Updated dependencies (_service update_).

## [7.31.0] - 2024-01-25

### Changed

* Updated dependencies (_service update_).

### Fixed

* Remove locked version constraint for `illuminate/*` packages¹. 

¹: _"From version x" constraints were at some point removed by mistake and caused undesired locked/fixed versions of all Laravel packages._

## [7.30.1] - 2024-01-14

### Fixed

* Various code style errors (_happened after update of bin dependencies - easy coding standard_).

## [7.30.0] - 2024-01-14

### Changed

* Updated dependencies (_service update_).
* Updated "bin" dependencies (_this only affects the Athenaeum mono-repository / maintainers_).
* Changed test version to PHP `8.1` for the PHPCompatibility check.

## [7.29.0] - 2024-01-02

### Changed

* License year bumped to 2024.
* Updated dependencies (_service update_).

## [7.28.0] - 2023-12-13

### Changed

* Updated dependencies (_service update_).

### Fixed

* Unable to remove file, due to missing path prefix (_in Flysystem `DatabaseAdapter`_).

## [7.27.0] - 2023-11-24

### Changed

* Updated dependencies (_service update_).

## [7.26.0] - 2023-11-17

### Changed

* Updated dependencies (_service update_).

## [7.25.0] - 2023-10-25

### Changed

* Updated dependencies (_service update_).

## [7.24.0] - 2023-10-02

### Changed

* Updated dependencies (_service update_).

## [7.23.0] - 2023-09-15

### Changed

* Updated dependencies (_service update_).

## [7.22.1] - 2023-09-04

### Fixed

* `InfectionFreeFile` throws exception when invalid file is attempted scanned (_in the AntiVirus package_). [#180](https://github.com/aedart/athenaeum/issues/180).

## [7.22.0] - 2023-09-01

### Changed

* Updated dependencies (_service update_).

## [7.21.0] - 2023-08-25

### Changed

* Minimum required PHP version set to `8.1.22`, due to PHP's internal magic database. [#178](https://github.com/aedart/athenaeum/issues/178).

### Fixed

* Incorrect expected MIME-Type for `*.xz` files. Before PHP `8.1.22`, the `FileInfoSampler` returned `application/octet-stream`. It now returns `application/x-xz`, which is the correct MIME-Type for `*.xz` files. [#178](https://github.com/aedart/athenaeum/issues/178). 

## [7.20.0] - 2023-08-16

### Changed

* Updated dependencies (_service update_).

### Fixed

* Missing validation package dependency (_in the AntiVirus package_). [#176](https://github.com/aedart/athenaeum/issues/176). 

## [7.19.0] - 2023-08-07

### Changed

* Updated dependencies (_service update_).

## [7.18.1] - 2023-07-25

### Fixed

* Target `Illuminate\Contracts\Cache\Repository` is not instantiable while building `Illuminate\Console\Scheduling\ScheduleRunCommand`. [#174](https://github.com/aedart/athenaeum/issues/174).

## [7.18.0] - 2023-07-06

### Changed

* Updated dependencies (_service update_).

## [7.17.0] - 2023-06-27

### Changed

* Updated dependencies (_service update_).

## [7.16.0] - 2023-06-16

### Changed

* Updated dependencies (_service update_).
* Refactored `BaseStore` to use `match()` expression instead of `switch` (_in circuit breaker package_).
* Refactored `AppliesPayload` to use `match()` expression instead of `switch` (_in Http Client package_).
* Removed ignore rule for `\Aedart\Streams\Stream`, after update to latest version of PHPStan. [#173](https://github.com/aedart/athenaeum/issues/173).
* ~~Ignored `\Aedart\Streams\Stream` from being scanned by PHPStan, due to incorrect "_`__debugInfo()` is not covariant with return type array of method Aedart\Contracts\Streams\Stream::__debugInfo()_" error message. [#173](https://github.com/aedart/athenaeum/issues/173).~~
* `Precision` cases documented using PHPDoc (_in Utils package_).

## [7.15.0] - 2023-05-31

### Changed

* Updated dependencies (_service update_).

## [7.14.0] - 2023-05-15

### Changed

* Updated dependencies (_service update_).

## [7.13.0] - 2023-05-04

### Added

* Support for low/high datetime range offset for milliseconds precision, if Eloquent model's datetime format supports it.  
* Date or datetime `Precision` enum, in utils package. 

### Changed

* Applied datetime format is now derived from Eloquent model (_when query is from a model_), in `DatetimeFilter`. Setting manual format is still supported. 

### Fixed

* Additional "high" range date constrain for `<=` and `>` causes incorrect results, in `DatetimeFilter`. These constraints have now been removed again.  

## [7.12.0] - 2023-05-03

### Added

* Custom `DateFormat` validation rule.

### Changed

* `DateFilter` and `DateTimeFilter` are now be able to accept RFC 3339 Extended Zulu formatted input and deal with UTC, even when timezone is submitted as `'+00:00'` or `'Z'`.

## [7.11.3] - 2023-04-28

### Fixed

* Incorrect inclusive or exclusive ranges query built, for when `!=` operator, in `DatetimeFilter` (_entire query refactored!_). [#170](https://github.com/aedart/athenaeum/issues/170).

### Deprecated

* `datetimeRangeComparison()` method (_in `BaseFieldFilter`_) because it does not produce correct range, in combination with `!=` filter operator. [#170](https://github.com/aedart/athenaeum/issues/170).

## [7.11.2] - 2023-04-20

### Fixed

* "_Class based after validation rules_" feature (_introduced in Laravel `v10.8.0`_) breaks abstract `ApiValidatedRequest`. [#167](https://github.com/aedart/athenaeum/pull/167).
* Undefined array key when Http Status Code does not have a default status text, in `ApiErrorResponse::makeFor()`. [#166](https://github.com/aedart/athenaeum/pull/166).

### Deprecated

* `after()` method in `ApiValidatedRequest`. This method will be removed in the next major version. Replaced by the new `afterValidation()` method.  [#168](https://github.com/aedart/athenaeum/pull/168).

## [7.11.1] - 2023-04-18

### Fixed

* Target identifier rules not applied in `ProcessMultipleResourcesRequest`. Rules were wrapped in a closure which never got invoked. [#165](https://github.com/aedart/athenaeum/pull/165).

## [7.11.0] - 2023-04-15

### Changed

* Updated minimum required dependencies (_chore_).

## [7.10.1] - 2023-04-07

### Fixed

* Missing implementation of abstract `setUpTheTestEnvironmentTraitToBeIgnored` (_declared in `\Orchestra\Testbench\Concerns\Testing`, since Orchestra Testbench `v8.4.0`_).

## [7.10.0] - 2023-03-26

### Changed

* Migrated documentation to use [vuepress v2](https://v2.vuepress.vuejs.org/). Also given the docs an improved look & feel. [#163](https://github.com/aedart/athenaeum/issues/163).

## [7.9.1] - 2023-03-17

### Fixed

* Default Eloquent Etag is not unique after it has been updated, due to `updated_at` not correctly obtained, in `EloquentEtag` concern.  

## [7.9.0] - 2023-03-17

### Changed

* `GenericResource` now accepts a `callable` etag, which is invoked when the etag is requested from the resource.
* `CreateSingleResourceRequest`, and `ShowSingleResourceRequest` now use a callback to resolve resource's etag, which increases performance in situations when no request is not conditional (_no preconditions requested_). 

## [7.8.0] - 2023-03-16

### Added

* `RouteParametersValidation` concern, in Http Api package.

## [7.7.2] - 2023-03-15

### Fixed

* `$record` argument ignored when authorizing found record, in `ShowSingleResourceRequest`, `UpdateSingleResourceRequest` and `DeleteSingleResourceRequest`. 

## [7.7.1] - 2023-03-14

### Fixed

* Call to undefined `getStatusCode()`, when no Http status provided and given exception is not instance of `HttpExceptionInterface`, in `ApiErrorResponse::makeFor()`. 

## [7.7.0] - 2023-03-13

### Changed

* `getModel()` is now able to return assigned model from new `usingModel()` method, in `BaseRelationReference`.

## [7.6.0] - 2023-03-13

### Added

* `asSingleModel()` and `asMultipleModels()` shortcut methods for determining how to format loaded relation, in `BaseRelationReference`.

## [7.5.0] - 2023-03-12

### Added

* [`Pipeline` and `PipelineHub`](https://laravel.com/docs/10.x/helpers#pipeline) aware-of helpers, in Support package.
* `PasswordBroker` and `PasswordBrokerManager` aware-of helpers, in Support package.

### Change

* Minimum required version of Laravel packages changed to `v10.3`.
* Reduced `sample_size` to 512 bytes, for "file-info" in tests, for the Mime Types package (_Now in accordance with official documentation_).
* Improved documentation regarding supported types, for the Configuration package.

## [7.4.0] - 2023-03-01

### Added

* Antivirus package, with a default [ClamAV](https://www.clamav.net/) scanner and validation rule for file uploads.
* `BaseValidationRule` abstraction in Validation package (_an alternative to the deprecated `BaseRule` abstraction_).
* `buffer()` method in `Stream` (_not yet available in interface_).
* `openFileInfo()`, `openUploadedFile()`, `copyFrom()` and `filename()` methods in `FileStream` (_not yet available in interface_).
* `Driver`, `MockableDriver`, `DriverProfile`, and `DriverOptions` concerns in Utils package.

### Changed

* Renamed internal `performCopy()` to `copySourceToTarget()` in `Copying` concern in Stream package.
* Refactored internal `outputSingleRange()` method in `DownloadStream`. Now uses stream `buffer()` method.
* Improved method description of `copy()` and `copyTo()` methods, in `FileStream`.
* Improved documentation regarding which read methods automatically rewinds the stream. 

### Fixed

* Incorrect "is readable" check of source stream in `copy()` and `copyTo()`, in `FileStream`.
* Incorrect description of `append()` method in documentation, regarding PSR-7 stream detaching.

### Deprecated

* All concerns in the `\Aedart\Validation\Rules\Concerns\*` namespace. These will be removed in the next major version. 
* `\Aedart\Contracts\Validation\FailedState`. Will be removed in the next major version.
* `\Aedart\Validation\Rules\BaseRule`. Will be removed in the next major version. Use `\Aedart\Validation\Rules\BaseValidationRule` instead. 

## [7.3.0] - 2023-02-23

### Added

* Translation package, with a profile-based translation exporter component.
* Laravel Translation Loader aware component, in Support package.

## [7.2.0] - 2023-02-19

### Added

* Support for parsing `*.neon` files, in Config package.
* Enabled static analysis of all source code, using [PHPStan](https://phpstan.org/). 

### Changed

* Improved the `deploy-docs.sh` script.

### Fixed

* Unable to parse `*.yaml` configuration files in `FileParserFactory` (_Config package_).
* Removed duplicate path from easy-coding-standards configuration.
* `GuzzleHttp\Psr7\stream_for` not found, in `InvalidHttpMessage` (_test utility_)
* Incorrect check of trait usage by service provider, in Service `RegistrarTest`

## [7.1.0] - 2023-02-18

### Added 

* Authentication package, with a Laravel Fortify action for rehashing user's password after login.

### Changed 

* `ApplicationInitiator` now offers utilities to set `APP_KEY`, in Testing package.
* `$enablesPackageDiscoveries` set to `false` in `ApplicationInitiator` (_was previously not specified_).

### Fixed

* Resources from previous conducted tests are published, despite not registered. Fixed in `ApplicationInitiator` (_Testing package_) and `Application` (_Core application package_).
* Missing return type for `count()` methods, in `\Aedart\Streams\Stream`, `\Aedart\Http\Api\Resources\SelectedFieldsCollection`, and `\Aedart\Utils\Memory\Unit`.
* Missing return type for `__toString()` methods, in `\Aedart\ETags\ETagsCollection`, and `\Aedart\MimeTypes\MimeType`.
* Missing return type for `jsonSerialize()`method, in `\Aedart\ETags\ETagsCollection`.
* Incorrect return type for `__debugInfo()`, in `\Aedart\Testing\Helpers\Http\MultipartResponse` and `\Aedart\Testing\Helpers\Http\MultipartContent`.
* Summation collection unit test has a high probability of failure, due to weak generated random number.

## [7.0.1] - 2023-02-16

### Fixed

* Invalid `illuminate/testing` version constraint in Testing package.

## [7.0.0] - 2023-02-16

###  Fixed

* Interdependencies of all Athenaeum packages. Force release major version `7.0.0`¹. 

¹: _This issue was caused by [monorepo builder](https://github.com/symplify/monorepo-builder/issues/25) and prevented correct version download of the alpha pre-releases._

## [7.0.0-alpha.1] - 2023-02-16

###  Fixed

* Split workflow fails to push packages, due to strange [directory ownership issue of `/tmp/monorepo_split/build_directory`](https://github.com/danharrin/monorepo-split-github-action/pull/44). 

## [7.0.0-alpha] - 2023-02-16

### Added

* Http conditional request evaluator, with support of [RFC9110 preconditions](https://developer.mozilla.org/en-US/docs/Web/HTTP/Conditional_requests), in the ETags package.
* API Request abstractions, in the Http Api package.
* Support for uploading data using a stream, via `attachStream()` method, in Http Clients package.
* `DownloadStream` response helper that is able to output an entire attachment, single part, or multipart (_range download_), in ETags package.
* `HttpCaching` concern in `ApiResource`, which can make it easier to set Http Cache Control headers.
* `HasArbitraryData` interface and a default implementation in `ArbitraryData` concern, as part of the utils package. 
* `sync()` method added for `FileStream`. [#105](https://github.com/aedart/athenaeum/issues/105).
* `BaseSearchQuery` and `BaseSortingQuery` abstractions for custom filtering queries via `SearchFilter` or `SortFilter`, in the filters package.
* `Database` utility component, in the database package.
* Query `Joins` concern, in the database package.
* `Prefixing` concern, in the database package.
* `BaseRule` can now set and obtain a `FailedState` (_a [`UnitEnum`](https://www.php.net/manual/en/class.unitenum.php)_), to allow handling of more complex error messages.
* `RemoveResponsePayload` middleware in the Http Api package.
* Audit `Callback` helper, which allows setting a custom message for all audit trail events dispatched in a callback.
* `BulkRecorder` helper in audit package.
* `recordNewChange()` util method in `ChangeRecording` concern, in audit package.
* Service `Registrar` invokes booting and booted callbacks of service providers.
* Service `Registrar` can now bind singleton instances of non-associative `$singletons` array, if available in service providers.
* `hasDebugModeEnabled()` in Core `Application` (_defined by Laravel's `Application` interface, from `v10.x`_).
* `DateTimeFormats` interface that contains PHP's predefined date and time formats, along with a few additional, such as RFC3339 that supports `"Z"` or `"-/+00:00"` offset.
* `asMicroSeconds()` in the `Duration` util.
* `setAllowedDateFormats()` in `DateFilter`.
* `setDatabaseDatetimeFormat()` in `BaseFieldFilter` abstraction.
* Several `is{status}` methods added in Response `Status`, as well as additional Http status code utilities. 
* `now()` in the `Duration` util.
* `to()` method in Memory `Unit` util.
* Test `Response` utility.
* `MultipartResoonse` testing utility.

### Changed

**Breaking Changes**

* Minimum required PHP version changed to `v8.1`.
* Adapted CI environment to test PHP `v8.1` and `v8.2`.
* Upgraded to use Laravel `v10.x` packages.
* `FieldFilter` constructor and `make()` method arguments are now optional, to allow creating instances without triggering immediate validation of field, operator and value.
* `DateFilter::allowedDateFormats()` visibility changed to public and now returns default date / datetime formats, when none specified.
* `ApiResourceServiceProvider` changed to be an aggregate service provider that automatically registers `ETagsServiceProvider`.
* `SearchFilter` no longer applies unnecessary query constraint (_the first comparison constraint_).
* Dispatching "multiple models changed", via `ModelChangedEvents::dispatchMultipleModelsChanged` no longer skips all models, if the first is marked as "skip next recording", in audit package.  
* `$models` attribute (_public_) can no longer be an `array`, in `MultipleModelsChanged`. Attribute must be of `Collection` instance.
* `ModelChangedEvents` has been redesigned to accept all supported arguments for model changed events.
* `publicPath()` and `langPath()` method signatures changes, in Core `Application`. Methods are now inherited from Laravel's `Application` interface (_Laravel `v10.x`_).

**Non-breaking Changes**

* `SearchFilter` and `SearchProcessor` now support custom search callbacks. [#129](https://github.com/aedart/athenaeum/issues/129).
* `SortFilter` and `SortingProcessor` now support custom sorting callbacks.
* `getResourceKeyName()` in `ApiResource` now throws `LogicException`, if unable to determine resource's identifier key name.
* `hash()` method can now accept options for the specified hashing algorithm. [#106](https://github.com/aedart/athenaeum/issues/106).
* Methods for setting and determining if datetime should be converted to UTC, in `DatetimeFilter`.
* Switched to [`xxHash`](https://php.watch/versions/8.1/xxHash) as default hashing algorithm in etags `BaseGenerator` and example configuration.
* Temporary and public URL tests for database adapter are forced to evaluate to true. Original tests marked them as skipped, because features are not supported.
* Extracted translation utilities into own trait in `BaseRule`, which now allow setting translation key prefix (_vendor prefix_). [#114](https://github.com/aedart/athenaeum/issues/114).
* Extracted `$attribute` into own trait in `BaseRule`. Can now be set or obtained via appropriate getter and setter methods.
* `MicroTimeStamp::fromDateTime()` now accepts `\DateTimeInterface` instead of `\DateTime`.
* `Duration` now accepts `\DateTimeInterface` instead of `\DateTime`.
* `RequestETagsMixin::httpDateFrom()` now parses Http Date acc. to RFC9110 (_a looser date format parsing was previously used_).
* Response `Status` interface  now extends `\Stringable` (_Http Clients package_).
* Response `Status` now guesses a status phrase when none given.

### Fixed

* `DatetimeFilter` does not accept dates formatted as RFC3339 with `"Z"` (_Zulu_). 
* Typed property `Duration::$microTimeStamp` must not be accessed before initialization.
* Monorepo builder configuration broken after update.
* Code style of all packages. Easy coding standard configuration, in `ecs.php`, was previously not applied correctly.


### Deprecated

* `\Aedart\Audit\Traits\RecordsChanges` trait. Replaced by `\Aedart\Audit\Concerns\ChangeRecording`.
* `\Aedart\Audit\Traits\HasAuditTrail` trait  Replaced by `\Aedart\Audit\Concerns\AuditTrail`.
* `\Aedart\Audit\Models\Concerns\AuditTrailConfiguration` concern. Replaced by `\Aedart\Audit\Concerns\AuditTrailConfig`.

### Removed

* `SearchProcessor::language()`. Features didn't work as intended. No replacement has been implemented.
* `Str::tree()`. Replaced by `Arr::tree()`.

## [6.8.1] - 2023-01-19

### Fixed

* Type Error when attempting to parse etags collection from Http header value that was set to `null`, in `\Aedart\ETags\Mixins\RequestETagsMixin::etagsFrom()`.

## [6.8.0] - 2023-01-09

### Changed

* Bumped license year.

## [6.7.0] - 2022-12-03

### Changed

* The `DatabaseAdapter` now supports League's [checksum](https://flysystem.thephpleague.com/docs/usage/checksums/) operation. [#121](https://github.com/aedart/athenaeum/issues/121).

### Removed

* `throw` option for flysystem database connection. This option was never used.

### Deprecated

* `language()` method in `SearchProcessor`. This method has no effect on the search processor, nor its underlying `SearchFilter`. [#125](https://github.com/aedart/athenaeum/issues/125).

## [6.6.0] - 2022-11-28

### Added

* New ETags utilities package. [#126](https://github.com/aedart/athenaeum/pull/126).

### Changed

* Useless `$notFoundMsg` is now removed, inside Circuit Breaker Manager's internal "find or fail" methods (_cleanup_).
* Root package `composer.json` now uses "self.version" again, for the Athenaeum packages it replaces.

### Fixed

* Default configuration directory changed to `config/`, to match a default Laravel application (_fixed in documentation_). 

## [6.5.2] - 2022-11-13

### Fixed

* `ErrorException` Undefined array key "driver". [#123](https://github.com/aedart/athenaeum/issues/123), [#124](https://github.com/aedart/athenaeum/issues/124).

This defect was introduced by `orchestra/testbench`, from ` v7.12.0`, in which the "testing" database connection configuration was removed.
Several tests assumed that a "testing" connection was available and attempted to use it.
A custom `TestingConnection` util class now ensures such a connection exists for affected tests.

## [6.5.1] - 2022-11-04

### Fixed

* Unintended filter criteria overwrite in `ConstraintsProcessor`. [#117](https://github.com/aedart/athenaeum/issues/117), [#118](https://github.com/aedart/athenaeum/pull/118).

## [6.5.0] - 2022-10-23

### Added

* Http Api utilities package. [#116](https://github.com/aedart/athenaeum/pull/116).

### Changed

* CI environment now runs on Ubuntu 22.04. Also added minor improvements to the PHP settings. 

## [6.4.0] - 2022-09-18

### Added

* Documentation for `\Aedart\Utils\Arr::tree()`.

### Changed

* Upgraded minimum required patch versions of all major dependencies (_Maintenance_).

### Deprecated

* `\Aedart\Utils\Str::tree()`, replaced by `\Aedart\Utils\Arr::tree()`. Method will be removed in next major version. 

### Fixed

* Uncaught Error: Class "Normalizer" not found, in monorepo builder (_vendor-bin dependency_). 

## [6.3.0] - 2022-07-14

### Changed

* RFC3339 Extended datetime format is now also supported by default, in `DatetimeFilter`.
* Codeception upgraded to `5.0.0-RC6`

### Fixed

* Broken test in `DatabaseAdapterTest`, due to update in either PHPUnit or Codeception's way of handling "data providers".

## [6.2.1] - 2022-05-28

### Fixed

* Domain name set to `0`, when none provided for Cookie, in `CookiesHelper` (_Http Clients package_).
* Broken Set Cookie tests.
* `ContainerConfigurator` no longer supported, in `ecs.php` (_easy coding standard configuration_).

### Changed

* Upgraded min. required version of `guzzlehttp/guzzle` to `7.4.3`, due to [Cross-domain cookie leakage](https://github.com/guzzle/guzzle/security/advisories/GHSA-cwmx-hcrq-mhc3).

## [6.2.0] - 2022-05-11

### Added

* Flysystem Database Adapter package.

### Fixed

* `file` driver not found in Core application / Maintenance Mode. This was caused due to missing default configuration for maintenance mode, and after Laravel `v9.9` added a default value for their configuration. 

## [6.1.1] - 2022-04-27

### Fixed

* Incorrect setter method signature, in `\Aedart\Support\Helpers\Database\DbTrait`

## [6.1.0] - 2022-04-25

### Changed

* `\Aedart\Utils\Version::application()` can now accept a path to a "version file" (_optional_), which replaces the default obtain version information from composer. [#108](https://github.com/aedart/athenaeum/issues/108) 

## [6.0.2] - 2022-04-07

### Fixed

* Unintended version lock of required Laravel packages in `composer.json`.

## [6.0.1] - 2022-04-05

### Fixed

* Missing `aedart/athenaeum-mime-types` dependency in streams package.
* "src refspec master does not match any" in Monorepo builder script.

## [6.0.0] - 2022-04-05

### Added

* Streams package that offers wrappers for common stream operations.
* `Dto` and `ArrayDto` can now accept and resolve union types. [#82](https://github.com/aedart/athenaeum/issues/82).
* MIME-types detection package, based on file's contents via a string, resource of path.
* Maintenance Mode package that offers additional drivers for Laravel's Application, when using `php artisan down`. Available drivers: `'array'` and `'json'`. [#67](https://github.com/aedart/athenaeum/issues/67).
* `EnvironmentHandler` interface in Core package, as a replacement for the application environment related methods, that were removed from Laravel's foundation `Application` interface in version `9.x`. [#85](https://github.com/aedart/athenaeum/pull/85)
* `whereSlugNotIn()` method in `\Aedart\Database\Models\Concerns\Slugs` (_`Sluggable` interface also defines method_). [#64](https://github.com/aedart/athenaeum/issues/64).
* `fetchAll()` method for the `HasMany` relation, in Redmine package. [#57](https://github.com/aedart/athenaeum/issues/57).
* Optional `$mode` argument has been added to `\Aedart\Utils\Math::applySeed()`, which specifies the seeding algorithm to use. 
* Optional seeding algorithm `$mode` argument has been added to `\Aedart\Utils\Arr::randomElement()`.
* `hasCallback()` and `hasFallback()` methods added in `\Aedart\Utils\Helpers\Invoker`.
* Documentation for `\Aedart\Utils\Arr::differenceAssoc()` (_previously undocumented. Method was added in `v5.17`_). [#45](https://github.com/aedart/athenaeum/issues/45).
* Documentation for `\Aedart\Utils\Helpers\Invoker` (_previously undocumented. Helper was added in `v5.12`_).
* `InteractsWithDeprecationHandling` added to `LaravelTestHelper`.
* `isValid()` method in `Json` utility.
* `Memory` utility component.
* `split.yaml` GitHub Action workflow as replacement for previous "split" command from [Symplify Monorepo Builder](https://github.com/symplify/monorepo-builder). [#66](https://github.com/aedart/athenaeum/issues/66).
* Security and Support Policy. [#97](https://github.com/aedart/athenaeum/issues/97).
* Code of Conduct. [#97](https://github.com/aedart/athenaeum/issues/97).
* Documentation of Audit package. [#44](https://github.com/aedart/athenaeum/issues/44).

### Changed

**Breaking Changes**

* Minimum required PHP version changed to `v8.0.2`.
* Method arguments and return data types are changed (_all packages_), in accordance with PHP `v8.0`. Most fluent methods now return `static`. [#83](https://github.com/aedart/athenaeum/pull/83), [#77](https://github.com/aedart/athenaeum/issues/77).
* `populate()` method now returns `static` instead of `void`, in `\Aedart\Contracts\Utils\Populatable` interface.
* `all()` method added in `ApiResource` interface (_change is only breaking if you have custom implementation of interface_). [#54](https://github.com/aedart/athenaeum/issues/54).
* `fresh()` method added in Http Client `Manager` (_change is only breaking if you have custom implementation of interface_). [#51](https://github.com/aedart/athenaeum/issues/51).
* `PathsContainer` is now aware of "lang path" (_path to language files / directory_). The core application has also been modified to offer a `langPath()` method. [#76](https://github.com/aedart/athenaeum/issues/76).
* Replaced `\DateTime` with `\DateTimeInterface` for all date related aware-of helpers. The `\Aedart\Contracts\Utils\DataTypes::DATE_TIME_TYPE` has also been changed. [#75](https://github.com/aedart/athenaeum/issues/75). 
* `SearchFilter` no longer uses `StopWords` concern (_concern has been removed_). [#63](https://github.com/aedart/athenaeum/issues/63).
* Return type of `package()` and `application()` is now set to `\Aedart\Contracts\Utils\Packages\Version`, in `\Aedart\Utils\Version`.  [#68](https://github.com/aedart/athenaeum/issues/68).
* `PackageVersionException` is now thrown, when version cannot be obtained for a package, in `\Aedart\Utils\Version::package()`. [#68](https://github.com/aedart/athenaeum/issues/68).
* Default datetime format is now [RFC3339](https://datatracker.ietf.org/doc/html/rfc3339), when no format is specified, for all Http Query Grammars, in Http Clients package.
* `$seed` argument can no longer be `null` in `\Aedart\Utils\Math::applySeed()` method.

**Non-breaking Changes**

* `CHANGELOG.md` is now formatted according to [Keep a Changelog](https://keepachangelog.com/en/1.0.0/).
* `when()` and `unless()` methods accept a `callable` as the result argument. [#81](https://github.com/aedart/athenaeum/issues/81). 
* `storage_path()` helper in Core package will now pass `$path` argument to application `storagePath()` method, when application is available (_`$path` argument added in Laravel `v9.x`_).
* Core `Application` uses `'json'` file based maintenance mode as driver, when application state is "down". [#67](https://github.com/aedart/athenaeum/issues/67).
* `application()` method no longer uses git to obtain application's version. It now relies on Composer's `InstalledVersions::getRootPackage()`, in `\Aedart\Utils\Version`. [#68](https://github.com/aedart/athenaeum/issues/68).
* Refactored `ModelHasChanged` and `MultipleModelsChanged` events. Both events are now a bit more fluent, in Audit package.
* Refactored event listeners for Audit package. Listeners now inherit from base `RecordsEntries` abstraction.
* Replaced `fzaninotto/faker` package with `fakerphp/faker`. [#23](https://github.com/aedart/athenaeum/issues/23).
* Replaced property calls with method calls, on faker instance throughout many tests (_PHP faker deprecated several properties since `v1.14`_). [#23](https://github.com/aedart/athenaeum/issues/23).  
* Upgraded to [Symplify Monorepo Builder](https://github.com/symplify/monorepo-builder) `v10.x`. [#60](https://github.com/aedart/athenaeum/issues/60), [#65](https://github.com/aedart/athenaeum/pull/65).
* `\Aedart\Utils\Dates\Duration` now inherits from `Stringable`.
* `castAsDate()` now also accepts `DateTimeInterface` as argument, in `ArrayDto`. [#82](https://github.com/aedart/athenaeum/issues/82)
* Replaced `get_class()` calls with the use of new `::class` magic constant (_[introduced in PHP 8](https://www.php.net/manual/en/language.oop5.basic.php#language.oop5.basic.class.class)_). Change is throughout all packages.
* Replaced [Travis](https://www.travis-ci.com/) with [GitHub Actions](https://docs.github.com/en/actions) as CI service. [#102](https://github.com/aedart/athenaeum/issues/102)
* Contribution guide has been improved. [#97](https://github.com/aedart/athenaeum/issues/97).

### Removed

* `\Aedart\Filters\Query\Filters\Concerns\StopWords` has been removed. Component didn't work as intended and caused several issues. [#63](https://github.com/aedart/athenaeum/issues/63).
* `$language` argument from `\Aedart\Filters\Query\Filters\SearchFilter` (_was deprecated in `v5.25`_). [#63](https://github.com/aedart/athenaeum/issues/63).
* `undot()` from `\Aedart\Utils\Arr`. The `undot()` method has been implemented in Laravel's `Arr`, which acts as the base class for `\Aedart\Utils\Arr`. This change is not breaking.
* `terminating()` method from `\Aedart\Contracts\Core\Application`. Method is defined in Laravel's Application interfaces, which the core application inherits from.
* `configurationIsChanged()`, `getCachedConfigPath()`, `getCachedServicesPath()`, `getCachedPackagesPath()`, `getCachedRoutesPath()` and `routesAreCached()` methods from
Core `Application` (_methods were not supported to begin with. They were defined by Laravel's `Applicaiton` interface, but extracted into separate interfaces from `v9.x`_). [#86](https://github.com/aedart/athenaeum/pull/86).
* `audit-trail.listener` setting, in `/configs/audit-trail.php` configuration (_was deprecated in `v5.27`_).
* `MocksApplicationServices` removed from `AthenaeumTestHelper` and `LaravelTestHelper`. The "mock application services" helper has been deprecated by Laravel.

### Fixed

* `storagePath()` must be compatible with interface declared method, in `\Aedart\Core\Application` (_method was changed in Laravel `v9.x`_).
* Input value "filter" contains a non-scalar value, when attempting get array value from http query via inside `\Aedart\Filters\BaseProcessor::value()` (_happened after upgrade to the latest version Laravel / Symfony_). [#69](https://github.com/aedart/athenaeum/issues/69).
* Unexpected value for parameter "name": expecting "array". [#71](https://github.com/aedart/athenaeum/issues/71).
* Incorrect commit reference passed on to `\Jean85\Version`, in `\Aedart\Utils\Version` (_happened after upgrade to the latest version of "Pretty Package Versions"_).
* Schedule commands not registered in Core Application's console `Kernel` / Artisan. [#84](https://github.com/aedart/athenaeum/pull/84).
* `\Illuminate\Support\ServiceProvider` imported into `\Aedart\Contracts\Service\Registrar` interface. This created unintended dependency on Laravel package.
* `\Illuminate\Filesystem\Filesystem` imported into `\Aedart\Contracts\Support\Helpers\Filesystem\FileAware` interface. This created unintended dependency on Laravel package.
* `\Illuminate\Http\Request` imported into `\Aedart\Contracts\Support\Helpers\Http\RequestAware` interface. This created unintended dependency on Laravel package.
* `\Illuminate\Log\LogManager` imported into `\Aedart\Contracts\Support\Helpers\Logging\LogManagerAware` interface. This created unintended dependency on Laravel package.
* `\Illuminate\Routing\Redirector` imported into `\Aedart\Contracts\Support\Helpers\Routing\RedirectAware` interface. This created unintended dependency on Laravel package.
* `\Illuminate\Session\SessionManager` imported into `\Aedart\Contracts\Support\Helpers\Session\SessionManagerAware` interface. This created unintended dependency on Laravel package.
* `\Illuminate\View\Compilers\BladeCompiler` imported into `\Aedart\Contracts\Support\Helpers\View\BladeAware` interface. This created unintended dependency on Laravel package.
* `$_ENV['APP_ENV']` and `$_SERVER['APP_ENV']` not unset after each Application test, causing environment detecting tests to fail, in `\Aedart\Testing\Athenaeum\ApplicationInitiator`.
* `Codeception\TestCase\Test` class not found, in `\Aedart\Tests\Integration\Laravel\ApplicationInitiatorTest` (_happened after upgrade to the latest version of Codeception_). 
* `LoadSpecifiedConfiguration` may not inherit from final class. `\Aedart\Testing\Laravel\Bootstrap\LoadSpecifiedConfiguration` no longer inherits from `Orchestra\Testbench\Bootstrap\LoadConfiguration`, which has been declared final (_happened after upgrade to the latest version of Orchestra_).

## [5.27.0] - 2022-01-31

### Added

* `MultipleModelsChanged` event in Audit package.
* `RecordMultipleAuditTrailEntries` listener that handles `MultipleModelsChanged` events. Performs a mass insert of audit trail entries.
* `AuditTrailEventSubscriber` that will handle registration of Audit Trail related event listeners.

### Deprecated

* The `audit-trail.listener` configuration setting has been replaced with `audit-trail.subscriber`, in `configs/audit-trail.php`.
Will be removed in next major version (_in audit package_).

### Changed

* `ModelChangedEvents` concern is now able to dispatch "multiple models changed" event, via `dispatchMultipleModelsChanged()` (_in audit package_).

### Fixed

* `$performedAt` argument ignored in `\Aedart\Audit\Events\ModelHasChanged`.

## [5.26.0] - 2022-01-03

### Changed

* Bumped license year.

## [5.25.0] - 2021-12-14

### Changed

* Replaced [`ReflectionParameter::getClass`](https://www.php.net/manual/en/reflectionparameter.getclass.php) call in `IoCPartial` and `ArgumentFaker` with an alternative, because it's deprecated since PHP `v8.0`. [#61](https://github.com/aedart/athenaeum/issues/61).
* Replaced `socket_create()` call with `tempfile()`, in `JsonTest`. From PHP `v8.0`, the `socket_create()` method returns an object, which can be encoded to Json and thus defeats the purpose of the test. [#61](https://github.com/aedart/athenaeum/issues/61).
* Converting test model's primary key and auditable id to `string`, to avoid incorrect value comparison in PHP `v8.1`, in the `B0_AuditTrailTest`. [#61](https://github.com/aedart/athenaeum/issues/61).
* Upgraded phpcs, easy-coding-standard and other vendor-bin dependencies.

### Fixed

* Removal of stop words causes search results to become undesired. `SearchFilter` no longer automatically removes stop words search term. [#63](https://github.com/aedart/athenaeum/issues/63).

### Deprecated

* The `StopWords` concern has now been deprecated and `SearchFilter` no longer automatically removes anything from given search term. [#63](https://github.com/aedart/athenaeum/issues/63).

## [5.24.2] - 2021-12-10

### Fixed

* `required` validation rule triggered, despite valid value given in `DateFilter`. This happened only when field contained a table name prefix, e.g. "users.created_at".

## [5.24.1] - 2021-12-09

### Fixed

* Unable to use string value in `BelongsToFilter`, due to incorrect assertion.

## [5.24.0] - 2021-12-08

### Added

* `BelongsToFilter` that is able to constrain relations of the type "belongs to", in filters package.

### Changed

* Allowing `FieldCriteria` instances to be given in the `fitlers()`, in `ConstraintsProcessor`. This allows for more advanced filters setup.
* Example of `BaseFiltersBuilder` now uses a custom method for the sortable properties to columns map, in documentation.

## [5.23.0] - 2021-12-02

### Added

* `DateFilter` that is able to match dates stated in `Y-m-d` format.
* `UTCDatetimeFilter` converts given date to UTC, before attempts to match against database value.

### Fixed

* `DatetimeFilter` fails matching full date and time. New comparison logic has been added. Previously used Laravel's `whereDate()` query, which yielded incorrect results.

## [5.22.4] - 2021-11-29

### Fixed

* `SearchFilter` not applied when `'0'` given as search term.

## [5.22.3] - 2021-11-29

### Fixed

* `SearchProcessor` not applied when `'0'` given as search term.

## [5.22.2] - 2021-11-24

### Fixed

* Incorrect value assertion for `NumericFilter`, when `is_null` or `not_null` operators used.
* Applies list of numeric values validation, when neither `in` or `not_in` operator set, in `NumericFilter`.

## [5.22.1] - 2021-11-18

### Fixed

* Too aggressive stop-word removal, removes more than it should, in Filters package's `StopWords` concern.

## [5.22.0] - 2021-11-17

### Added

* Filters package. Offers a way to create query filters, based on received http query parameters. [#59](https://github.com/aedart/athenaeum/pull/59).

## [5.21.0] - 2021-11-05

### Added

* Query `Filter` and `FieldFilter` abstractions, in database package.
* `Filtering` concern for Eloquent models, in database package.

## [5.20.0] - 2021-09-09

### Added

* `all()` method in `RedmineApiResource`, which is able to automatically paginate through all available results. [#53](https://github.com/aedart/athenaeum/pull/53).

### Fixed

* Unable to run database migrations in tests. [#55](https://github.com/aedart/athenaeum/issues/55).

## [5.19.0] - 2021-09-07

### Added

* Redmine API Client package. [#52](https://github.com/aedart/athenaeum/pull/52).
* `fresh()` method in the Http Clients `Manger`; able to return a fresh Http `Client` instance, without having the instance cached. _The method is not yet supported by the `\Aedart\Contracts\Http\Clients\Manager` interface_.

### Changed

* `BaseSerializer` (_Http Message package_) will now re-encode json payloads with the `JSON_PRETTY_PRINT` set, if a message's if `content-type` header contains `/json` or `+json`. This makes it easier to read json payloads, in debugging situations.

### Fixed

* Call to undefined `GuzzleHttp\Psr7\parse_query()`, in the `C1_QueryTest` Http Client tests. [#49](https://github.com/aedart/athenaeum/issues/49).
* A few broken links (_incorrect paths_) in the documentation.

## [5.18.1] - 2021-07-13

### Fixed

* Array to string conversion error when comparing arrays, that contain nested empty arrays - in `Arr::differenceAssoc()`. [#47](https://github.com/aedart/athenaeum/issues/47).

## [5.18.0] - 2021-06-30

### Added

* `SemanticVersion` validation rule.

## [5.17.0] - 2021-06-28

### Added

* `differenceAssoc()` method in `Arr`. Able to compute the difference of multidimensional arrays.

## [5.16.0] - 2021-05-26

### Added

* `formatOriginalData()` and `formatChangedData()`, in  the `RecordsChanges` trait. This allows easier changes to the attributes / data to be stored in an Audit Trail entry.

### Changed

* `originalData()` and `changedData()` now invoke the new format data methods, in the `RecordsChanges` trait, Audit package.

## [5.15.0] - 2021-05-07

### Changed

**Breaking Changes**

* `AuditTrailServiceProvider` now publishes migrations rather than loading them directly. This allows changing to installation order (_migration file's timestamp_).

**Caution**: _These changes can affect rolling back migrations. Please (re)publish service provider's assets to ensure your application is able to roll back the `create_audit_trail_table` migration._

### Fixed

* Fails inserting a new audit trail entry into database when user no longer exists, in `RecordAuditTrailEntry` listener.
  User existence is now checked before inserting new entry. If the user does not exist, then `null` is set as the audit trail entry's user reference.

## [5.14.1] - 2021-05-06

### Fixed

* Update events were not triggered / dispatched correctly, because they were invoked after database transactions, in `ModelObserver` from the Audit package.
  Changed the `$afterCommit` to `false` as the default value, to overcome this issue.

## [5.14.0] - 2021-05-06

### Added

* Possibility to skip recording a model's changes, via the `skipRecordingNextChange` method, in `RecordsChanges` trait.

## [5.13.2] - 2021-05-05

### Fixed

* Soft-deleted models not able to be eager-loaded in `AuditTrail` model (_auditable relation_).

## [5.13.1] - 2021-05-04

### Fixed

* Incorrect `performed_at` date time value for `AuditTrail` records. Previously relied on a model's `updated_at` value, which might not be accurate due depending upon when a "model has changed" event is dispatched (E.g. before or after an operation).
  In other words, a previous / past `updated_at` value could be applied, which would be incorrect and inconsistent of with when a given event or action was performed.
  `performed_at` value no defaults to current date time.

## [5.13.0] - 2021-04-29

### Changed

* Extracted timestamp attributes names into own method, in `RecordsChanges` trait (_Audit package_), so that they can be obtained easier. This should allow better customisation of which fields to hide for Audit Trail entries.

## [5.12.0] - 2021-04-28

### Added

* Audit package; a way to automatically record Eloquent Model changes. [#43](https://github.com/aedart/athenaeum/pull/43)
* `Invoker` component, in `Utils` package.

## [5.11.0] - 2021-04-19

### Added

* Documentation for the ACL package. [#35](https://github.com/aedart/athenaeum/issues/35).
* Documentation for the validation package. [#38](https://github.com/aedart/athenaeum/issues/38).
* Documentation for the database package. [#36](https://github.com/aedart/athenaeum/issues/36).

### Fixed

* Incorrect permissions check, in `\Aedart\Acl\Traits\HasRoles::hasPermission`. Was unable to grant permission to a user, if permission was granted to multiple roles.

## [5.10.1] - 2021-03-25

### Fixed

* Fix ACL models not respecting database connection in transactions. In situations when a custom connection was set or resolved, the ALC Permissions `Group` and `Role` didn't use that given connection in their custom creation or update methods.

## [5.10.0] - 2021-03-25

### Added

* Several tests to verify behaviour of `Slugs` concern, in Database package. [#39](https://github.com/aedart/athenaeum/issues/39).
* `createWithPermissions()` and `updateWithPermissions()` helper methods in ACL `Role` Eloquent model. [#41](https://github.com/aedart/athenaeum/pull/41).

### Changed

* Removed unnecessary `$slug` merge into `$values` parameter in `Slugs::findOrCreateBySlug`, in Database package. [#40](https://github.com/aedart/athenaeum/pull/40).
* Replaced manual transaction rollback handling in `createWithPermissions()` method, inside ACL Permissions `Group` model. Now using Laravel's `DB::transaction()` method instead. [#41](https://github.com/aedart/athenaeum/pull/41).

## [5.9.0] - 2021-03-23

### Added

* Validation package that is intended to offer various rules and other validation related utilities. Presently, it only contains an `AlphaDashDot` rule. [#37](https://github.com/aedart/athenaeum/pull/37).

## [5.8.0] - 2021-03-21

### Added

* ACL package which offers a way to store roles and permissions (grouped) in a database. [#34](https://github.com/aedart/athenaeum/pull/34).
* Database utilities package. [#34](https://github.com/aedart/athenaeum/pull/34).
* `Sluggable` interface and `Slug` concern in new Database package.
* `Str` utility, which offers a few additional string manipulation methods.

### Fixed

* Unable to run database migrations via `LaravelTestCase`. Now implements `\Orchestra\Testbench\Contracts\TestCase`, which resolves the issue¹.

¹: _Orchestra's `MigrateProcessor` component, which is used behind the scene, has an explicit `TestCase` dependency. This cannot be circumvented without extensive overwrites of several migration helper methods._

## [5.7.0] - 2021-03-16

### Added

* `application()` method in `\Aedart\Utils\Version`, which is able to return application's version. [#25](https://github.com/aedart/athenaeum/issues/25)

### Fixed

* Too many Chrome driver processes started in `BrowserTestCase`, possibly causing a `Connection Refused` error. [#33](https://github.com/aedart/athenaeum/issues/33)

## [5.6.0] - 2021-02-20

### Added

* Collections package, with `Summation` and `ItemProcessor` components. [#27](https://github.com/aedart/athenaeum/issues/27)
* `undot()` method in `Arr` utility.

## [5.5.1] - 2021-02-10

### Fixed

* Incorrect teardown order in `BrowserTestCase`

## [5.5.0] - 2021-02-10

### Fixed

* Facade root not set during test teardown, in `LaravelTestCase` and `ApplicationInitiator`¹.
* Laravel's `Application` still bound as `IoC`'s static instance, causing strange behaviour in some tests².

¹: _The happened sometime after Laravel released the "parallel testing" feature and Orchestra Testbench enabled it._
²: _Unintended side effect of fixing the `ApplicationInitiator`._

### Changed

* Bumped license year, in `LICENSE` files.
* Minimum required [Orchestra Testbench](https://packagist.org/packages/orchestra/testbench) set to `v6.12.x`.

## [5.4.0] - 2021-01-08

### Changed

* `ApplicationInitiator` now makes use of custom `LoadSpecifiedConfiguration`.
  A previously added, but not applied specialisation of Orchestra `LoadConfiguration`.
  Custom component allows specifying the location of configuration files to be loaded, via `getBasePath()` and `getConfigPath()` methods¹.

¹: _This change will implicit ensure that changes to `LoadConfiguration` will be caught by tests and thereby prevent defects that resulted in patches `v5.3.3` to `v5.3.5`._

## [5.3.5] - 2021-01-06

### Fixed

* Incorrect format yield from `getConfigurationFiles` method, in `LoadSpecifiedConfiguration` Testing utility¹.

¹: _Was in a hurry to fix a "minor" defect, which just caused several other minor defects._

## [5.3.4] - 2021-01-06

### Fixed

* `getConfigurationFiles` method still returned `array` instead of specified `Generator`, in `LoadSpecifiedConfiguration` Testing utility.

## [5.3.3] - 2021-01-06

### Fixed

* Incorrect return type for `getConfigurationFiles` method, in `LoadSpecifiedConfiguration` Testing utility.

## [5.3.2] - 2020-12-28

### Fixed

* Boundary values incorrectly shown when using `toHoursMinutes()` and `toMinutesSeconds()`, in `Duration` utility. 
E.g. when attempting to convert -2700 seconds to hours and minutes, the `toHoursMinutes()` method return 00:45, instead of -00:45.

## [5.3.1] - 2020-12-28

### Fixed

* `toHoursMinutes()` not able to show above 24 hours, in `Duration` utility.
* `toMinutesSeconds()` not able to show above 60 minutes, in `Duration` utility.

Both methods failed showing a correct amount, whenever the initial value surpassed 24 hours (_or 60 minutes for `toMinutesSeconds()`_).

## [5.3.0] - 2020-12-27

### Added

* `fromHoursMinutes` and `fromStringHoursMinutes` methods in `Duration` utility.

### Changed

* Laravel `v8.15.x` packages are now required as a minimum.
* Updated [Orchestra Testbench](https://github.com/orchestral/testbench-core) dependencies to `v6.9.x`.
* Added leading zero for `Durataion::toHoursMinutes` short format.
* Disabled `failsIfCacheIsNotLockProvider` test, since botch file and null cache drivers [now support locks](https://github.com/laravel/framework/blob/8.x/CHANGELOG-8.x.md#v8150-2020-11-17).

## [5.2.1] - 2020-11-09

### Fixed

* Invalid `$this` reference in `static function`, in `DuskTestHelper`.
* Call to unknown `makeChromeOptions()` method.

## [5.2.0] - 2020-11-09

### Added

* `LoadSpecifiedConfiguration` bootstrapper, in `Testing` package. Intended for Laravel and Laravel Dusk tests.
* `$browserSourceOutput` property. Location where a page's source code is to be stored, in `DuskTestHelper`.

### Changed

* Switched back to `ChromeOptions::CAPABILITY` (_which is deprecated_), because `ChromeOptions::CAPABILITY_W3C` ignores command line arguments for Chrome Driver, in `DuskTestHelper`.
* Extracted configuration loader binding into own method / property, in `DuskTestHelper`. This makes it easier to overwrite, when needed.

## [5.1.0] - 2020-10-16

### Added

* Added `DuskTestHelper` and `BrowserTestCase` helpers, which offers integration to [Laravel Dusk](https://laravel.com/docs/8.x/dusk).

### Changed

* Changed `LaravelTestHelper`, added `InteractsWithTime` ([Laravel's helper](https://laravel.com/docs/8.x/mocking#interacting-with-time)) and `InteractsWithViews`. [#20](https://github.com/aedart/athenaeum/issues/20).

## [5.0.2] - 2020-10-06

### Fixed

* Incorrect code style caused CI failure.

## [5.0.1] - 2020-10-06

### Fixed

* Http Message stream not rewound after serialization, when using `debug()`, `dd()` or `log()`. See [#19](https://github.com/aedart/athenaeum/issues/19) for details.
* Removed deprecated `CreateAwareOfCommand` reference from `athenaeum` console application.
* Fixed a few typos.

## [5.0.0] - 2020-10-04

### Added

* Added `ListResolver` component.
* Added `otherwise()` and `getOtherwise()` methods to Circuit Breaker.
* Http `Client` (_via Request `Builder`_) is now able to process `Middleware`.
* Added `Middleware` and `Handler` components for Http Client. Inspired by [PSR-15](https://www.php-fig.org/psr/psr-15/).
* Added `QueueHandler`, a middleware processing component for Http Client Requests.
* Added `AppliesResponseExpectations` middleware. Replacement for internal response expectations handling in Http `Client`.
* Added `ResponseExpectation` component.
* Added Http Message `Serializer` components, in `Aedart\Http\Messages` namespace.
* Added `RequestResponseDebugging` Middleware for Http `Client`.
* Support for loading [TOML](https://en.wikipedia.org/wiki/TOML) configuration files.
* Added Http Request `Builder` aware of component.
* Added `Duration` utility.
* PHP Compatibility check in Travis.

### Removed

* Removed internal `applyExpectations()` method from `Expectations` concern, in Http Client `Builder`. Has been replaced by `AppliesResponseExpectations` middleware.
* Removed `Aedart\Dto` (_was deprecated in `v4.x`_).
* Removed `Aedart\ArrayDto` (_was deprecated in `v4.x`_).
* Removed `Aedart\Console\CreateAwareOfCommand` (_was deprecated in `v4.x`_).
* Removed `Aedart\Console\CommandBase` (_was deprecated in `v4.x`_).
* Removed `Aedart\Console\AwareOfScaffoldCommand` (_was deprecated in `v4.x`_).
* Removed all helpers in `Aedart\Support\Properties\Mixed\*` namespace (_was deprecated in `v4.x`_).
* Removed all contracts in `Aedart\Contracts\Support\Properties\Mixed\*` namespace (_was deprecated in `v4.x`_).

### Changed

**Breaking Changes**

* Upgraded Laravel dependencies to `v8.x`.
* Added `bootstrap()` method in `\Aedart\Core\Console\Kernel`, due to Laravel's Console `Kernal` interface change. `runCore()` method will now invoke new bootstrap method.
* `getExpectations()` now returns array of `ResponseExpectation` instances, in Request `Builder`.
* Changed `StatusCodesExpectation`, now inherits from `ResponseExpectation`. Some internal methods have been redesigned. This change should not affect your code, unless you have custom Http Request `Builder` implementation.
* Changed `withExpectation()`, in Request `Builder`. Now accepts both a `callable` and a `ResponseExpectation` instance. This change should not affect your code, unless you have custom Http Request `Builder` implementation.
* Changed Request `Builder` and Http `Client` interfaces and concrete implementations. Now offers methods for adding `Middleware`. This change only affects you if you have a custom Http `Client` or Request `Builder` implementation.
* Changed Http `Client` and Request `Builder`, added debugging methods (`debug()`, `dd()`, `log()`...etc.). This change only affects you if you have a custom Http `Client` or Request `Builder` implementation.

**Non-breaking Changes**

* Added shortcut methods (_`getClient()` and `client()`_) for obtaining Http Client instance in `ProcessOptions`.
* Changed `HttpClientServiceProvider`, now inherits from the `AggregateServiceProvider` and registers the `HttpSerializationServiceProvider` automatically. This eliminates setup of debugging components, for the Http `Client`.

### Fixed

* Fixed incorrect type declarations in PHPDoc (_throughout various components_).
* Codeception broken after update (_in codeception version 4.1.x series_).

## [4.2.1] - 2020-07-31

### Security

* Bumped minimum required dependencies, due to [security issue / release from Laravel](https://blog.laravel.com/laravel-cookie-security-releases).

## [4.2.0] - 2020-07-05

### Added

* Circuits package that offers a `CircuitBreaker`, with a `Manager` (profile-based).

## [4.1.0] - 2020-04-22

### Added

* `LaravelExceptionHandler` adaptor

### Fixed

* Unable to run `schedule:run` command. [#10](https://github.com/aedart/athenaeum/issues/10)

### Changed

* Minimum required Laravel packages version set to version `^7.7`


## [4.0.1] - 2020-04-15

### Fixed

* Broken interdependencies in all packages. Removed version `v4.0` from packagist.org to prevent conflicts.

## [4.0.0] - 2020-04-15 [YANKED]

### Added

* `Application`, custom adaptation of Laravel's Application.
* `Kernel`, custom adaptation of Laravel's Console Application (Artisan).
* `Registrar`, able to register service providers.
* `IoCFacade`, able to resolve bindings or return a default value, if binding does not exist.
* `LastInput` and `LastOutput` aware components (console).
* `ListenersViaConfigServiceProvider`, offers registration of event listeners and subscribers via configuration.
* `ConsoleServiceProvider`, offers console commands to be registered via configuration.
* `BaseExeptionHandler` abstraction along with a few default exception handlers that can be used with `Application`, if enabled.
* `Builder`, a Http request builder used by the Http `Client`.
* Http Query `Builder`, used by the request builder.
* `Grammar` abstraction to compile Http Query string - three grammars are offered: `DefaultGrammar`, `JsonApiGrammar` and `ODataGrammar`.
* `FakerAware` component that can be used for testing purposes.
* `FakerPartial`, offers basic setup for [Faker](https://github.com/fzaninotto/Faker).
* `callOrReturn()` utility method in `MethodHelper`.
* `MessageBag` testing component. Intended to store test or debugging messages across components and tests.
* `Version` utility.
* `Math` utility.
* `Arr` utility.
* `string` and `int` `Milestone` aware components
* `ApplicationInitiator` and `AthenaeumTestHelper`, testing utilities for the custom adaptation of Laravel's Application.
* `MailManagerAware` and `MailManagerTrait` Laravel Aware-of Helper.
* Http- `ClientFactoryAware` and `ClientFactoryTrait` Laravel Aware-of Helper.
* `Cookie` and `SetCookie` DTOs.

### Deprecated

* Deprecated `\Aedart\Console\CommandBase`, `\Aedart\Console\AwareOfScaffoldCommand` and `\Aedart\Console\CreateAwareOfCommand` components.
  Commands have been replaced with updated versions within the [`aedart/athenaeum-support `](https://packagist.org/packages/aedart/athenaeum-support) package.
  The original commands are still available using the `athenaeum` console application.
* Deprecated all aware-of helpers that contained `*\Mixed\*` in their namespace.
  These will be removed in next major version.
  Replacement components are available within the `*\Mixes\*` namespace.
  The term `Mixed` has been a [soft-reserved keyword](https://www.php.net/manual/en/reserved.other-reserved-words.php) since PHP `v7.0`.

### Changed

**Breaking Changes**

* Required PHP version changed to `v7.4.x`.
* Upgraded Laravel dependencies to `v7.6.x`, Symfony to `v5.0.x`, Codeception to `v4.1.x`, and various other dependencies.
* All class properties now have their [types declared](https://www.php.net/manual/en/migration74.new-features.php#migration74.new-features.core.typed-properties), if possible.
* `dto:create` command now generates traits with class [type declarations](https://www.php.net/manual/en/migration74.new-features.php#migration74.new-features.core.typed-properties) for its properties (_former `dto:create-aware-of` command_).
* `Dto` and `ArrayDto` now implements the `__serialize()` and `__unserialize()` magic methods.
* Replaced `\Aedart\Dto` with `\Aedart\Dto\Dto`¹.
* Replaced `\Aedart\ArrayDto` with `\Aedart\Dto\ArrayDto`¹.
* [Codeception](https://github.com/Codeception/Codeception) and [Orchestra Testbench](https://github.com/orchestral/testbench) are now defined as dev-dependencies.
  You need to require these packages, if you depended on them².
* (_Fix_) `IoC` no longer high-jacks Laravel's `app` binding automatically, when `getInstance()` is invoked.
  This was used to get some of Laravel's components to work outside the scope of a Laravel application.
  Yet, this was a "hack" that potentially could lead to conflicted with Laravel. This was never intended³!
* Redesign entire Http `Client` package, now makes use of a Request Builder and Http Query Builder.

**Non-breaking Changes**

* Converted athenaeum into a true [mono repository](ttps://en.wikipedia.org/wiki/Monorepo). All major components are now available as separate packages, via composer.
* Code style to [PSR-12](https://www.php-fig.org/psr/psr-12/).
* Replaced deprecated `Twig` components, in `TwigPartial` trait.
* `UnitTestCase` now uses `FakerPartial` for setup [Faker](https://github.com/fzaninotto/Faker).
* `UnitTestCase` now inherits from Codeception's `Unit` test-case.
* Using `IoCFacade` to resolve default Http Client `Manager`, in `HttpClientsManagerTrait`.
* Added `\Aedart\Contracts\Container\IoC` and `\Illuminate\Contracts\Container\Container` as `app` binding aliases, in `IoC`³.
* Added possibility to specify specific `vendor` and `output` paths for `interfaces` and `traits`, in the aware-of `Generator`.
* `getHeader()` is now case-insensitive, in `DefaultHttpClient` and `JsonHttpClient`.
  Handling of headers is now more inline with [PSR-7](https://www.php-fig.org/psr/psr-7/#12-http-headers).
* Added `data_format` option for Http Clients.

¹: _Deprecation of existing abstractions or components is due to the conversion of this package into a [mono repository](ttps://en.wikipedia.org/wiki/Monorepo).
Existing abstractions are still available, yet will be removed entirely in `v5.0`._

²: _You can require packages separately or if you only use the "testing" components, then replace this package with [`aedart/athenaeum-testing`](https://packagist.org/packages/aedart/athenaeum-testing) as dev-dependency and the mentioned packages will all be installed._

³: _You have to invoke `registerAsApplication()` explicitly to bind the `IoC` instance as `app`, should you require this during testing or outside a Laravel application.
**Warning**: do NOT invoke mentioned method if you are using the `IoC` within a Laravel application.
It will high-jack the `app` binding, which will cause your application to behave unfavourable._

### Fixed

* `Loader` fails to populate configuration correctly, adds initial directory path to each section.
  _This happens when relative paths are set as the loader's initial directory._
* `Applicaiton` instance not destroyed after `stopApplication()` invoked, in `ApplocationInitiator`.
  This resulting in `$instance` still containing reference to the application, inside Laravel's Service Container, causing tests to fail.
* `destroy()` does not flush bindings, in `IoC`. Instance is destroyed, yet formal Service Container `flush()` was not respected.
* Default values not triggered when invoking `toArray()`, in `Dto` and `ArrayDto`, when using aware-of traits to create a Dto class.
* `ContainerTrait`'s default value returns the `Facade` root application, instead of `Container`.
  (_Strictly speaking, this was not a defect. `Application` is an extended version of `Container`._)
* Headers option not initially set in `DefaultHttpClient`.
* Default return type of `MailerTrait` and `MailQueueTrait` (Laravel `v7.x` changed return of `Mail` Facade to `MailManager`).
* `withOptions()` incorrectly merged options, in `DefaultHttpClient` and `JsonHttpClient`.
  This caused strange behaviour, when attempting to overwrite an already set option.
* Http Client `Manager` does not use default profile name from configuration, it always returns "default", when no profile name given.

## [3.1.0] - 2020-01-01

### Changed

* Updated license

## [3.0.1] - 2019-09-29

### Fixed

* `LogicalException` thrown during travis build (_tests only_), caused by `PhpRedisConnector`. Changed test to use `predis` as default laravel redis connection.

## [3.0.0] - 2019-09-29

### Changed

**Breaking Changes**

* Upgraded to Laravel `v6.x`, Symfony `v4.3.x` and upgraded various other dependencies.

**Non-breaking Changes**

* Added `InteractsWithRedis` helper trait to the `LaravelTestHelper`.

### Removed

* Removed custom `JsonException` (_deprecated_), in `Json` utility. Now defaults to php's native [`JsonException`](https://www.php.net/manual/en/class.jsonexception.php).

## [2.3.0] - 2019-07-28

### Changed

* Now supporting Symfony Console version 4.3.x, [#2](https://github.com/aedart/athenaeum/issues/2)

## [2.2.0] - 2019-05-05

### Added

* Http Client package, a wrapper for [Guzzle Http Client](http://docs.guzzlephp.org/en/stable/index.html), offering multiple "profile" based client instances, which can be configured via a `configs/http-clients.php` configuration file.

### Changed

* Upgraded to codeception `v3.0.x` (_dev dependency_) and replaced deprecated assertions.

## [2.1.0] - 2019-04-14

### Changed

* Simplified the bitmask operation for the `\Aedart\Utils\Json`.

## [2.0.0] - 2019-02-28

### Changed

* Minimum required PHP version set to `v7.3.0`
* Main dependencies changed to Laravel `v5.8.x`, Symfony `v4.2.x` and Orchestra Testbench `v.3.8.x`
* `\Aedart\Utils\Json` automatically sets [`JSON_THROW_ON_ERROR`](http://php.net/manual/en/json.constants.php) bitmask option, if not set
* `Aedart\Utils\Exceptions\JsonEncoding` now inherits from [`JsonException`](http://php.net/manual/en/class.jsonexception.php)
* Replaced deprecated `PHPUnit_Framework_MockObject_MockObject` with new `\PHPUnit\Framework\MockObject\MockObject`, in `TraitTester`

### Deprecated

* Deprecated `\Aedart\Contracts\Utils\Exceptions\JsonEncodingException`, will be removed in next major version
* Deprecated `Aedart\Utils\Exceptions\JsonEncoding`. Use native [`JsonException`](http://php.net/manual/en/class.jsonexception.php) instead

## [1.0.0] - 2018-11-10

* Please review commits on [GitHub](https://github.com/aedart/athenaeum/commits/master)

[Unreleased]: https://github.com/aedart/athenaeum/compare/8.11.0...HEAD
[8.11.0]: https://github.com/aedart/athenaeum/compare/8.10.0...8.11.0
[8.10.0]: https://github.com/aedart/athenaeum/compare/8.9.0...8.10.0
[8.9.0]: https://github.com/aedart/athenaeum/compare/8.8.0...8.9.0
[8.8.0]: https://github.com/aedart/athenaeum/compare/8.7.0...8.8.0
[8.7.0]: https://github.com/aedart/athenaeum/compare/8.6.0...8.7.0
[8.6.0]: https://github.com/aedart/athenaeum/compare/8.5.0...8.6.0
[8.5.0]: https://github.com/aedart/athenaeum/compare/8.4.0...8.5.0
[8.4.0]: https://github.com/aedart/athenaeum/compare/8.3.0...8.4.0
[8.3.0]: https://github.com/aedart/athenaeum/compare/8.2.0...8.3.0
[8.2.0]: https://github.com/aedart/athenaeum/compare/8.1.0...8.2.0
[8.1.0]: https://github.com/aedart/athenaeum/compare/8.0.0...8.1.0
[8.0.0]: https://github.com/aedart/athenaeum/compare/7.33.0...8.0.0
[7.33.0]: https://github.com/aedart/athenaeum/compare/7.32.0...7.33.0
[7.32.0]: https://github.com/aedart/athenaeum/compare/7.31.0...7.32.0
[7.31.0]: https://github.com/aedart/athenaeum/compare/7.30.1...7.31.0
[7.30.1]: https://github.com/aedart/athenaeum/compare/7.30.0...7.30.1
[7.30.0]: https://github.com/aedart/athenaeum/compare/7.29.0...7.30.0
[7.29.0]: https://github.com/aedart/athenaeum/compare/7.28.0...7.29.0
[7.28.0]: https://github.com/aedart/athenaeum/compare/7.27.0...7.28.0
[7.27.0]: https://github.com/aedart/athenaeum/compare/7.26.0...7.27.0
[7.26.0]: https://github.com/aedart/athenaeum/compare/7.25.0...7.26.0
[7.25.0]: https://github.com/aedart/athenaeum/compare/7.24.0...7.25.0
[7.24.0]: https://github.com/aedart/athenaeum/compare/7.23.0...7.24.0
[7.23.0]: https://github.com/aedart/athenaeum/compare/7.22.1...7.23.0
[7.22.1]: https://github.com/aedart/athenaeum/compare/7.22.0...7.22.1
[7.22.0]: https://github.com/aedart/athenaeum/compare/7.21.0...7.22.0
[7.21.0]: https://github.com/aedart/athenaeum/compare/7.20.0...7.21.0
[7.20.0]: https://github.com/aedart/athenaeum/compare/7.19.0...7.20.0
[7.19.0]: https://github.com/aedart/athenaeum/compare/7.18.1...7.19.0
[7.18.1]: https://github.com/aedart/athenaeum/compare/7.18.0...7.18.1
[7.18.0]: https://github.com/aedart/athenaeum/compare/7.17.0...7.18.0
[7.17.0]: https://github.com/aedart/athenaeum/compare/7.16.0...7.17.0
[7.16.0]: https://github.com/aedart/athenaeum/compare/7.15.0...7.16.0
[7.15.0]: https://github.com/aedart/athenaeum/compare/7.14.0...7.15.0
[7.14.0]: https://github.com/aedart/athenaeum/compare/7.13.0...7.14.0
[7.13.0]: https://github.com/aedart/athenaeum/compare/7.12.0...7.13.0
[7.12.0]: https://github.com/aedart/athenaeum/compare/7.11.3...7.12.0
[7.11.3]: https://github.com/aedart/athenaeum/compare/7.11.2...7.11.3
[7.11.2]: https://github.com/aedart/athenaeum/compare/7.11.1...7.11.2
[7.11.1]: https://github.com/aedart/athenaeum/compare/7.11.0...7.11.1
[7.11.0]: https://github.com/aedart/athenaeum/compare/7.10.1...7.11.0
[7.10.1]: https://github.com/aedart/athenaeum/compare/7.10.0...7.10.1
[7.10.0]: https://github.com/aedart/athenaeum/compare/7.9.1...7.10.0
[7.9.1]: https://github.com/aedart/athenaeum/compare/7.9.0...7.9.1
[7.9.0]: https://github.com/aedart/athenaeum/compare/7.8.0...7.9.0
[7.8.0]: https://github.com/aedart/athenaeum/compare/7.7.2...7.8.0
[7.7.2]: https://github.com/aedart/athenaeum/compare/7.7.1...7.7.2
[7.7.1]: https://github.com/aedart/athenaeum/compare/7.7.0...7.7.1
[7.7.0]: https://github.com/aedart/athenaeum/compare/7.6.0...7.7.0
[7.6.0]: https://github.com/aedart/athenaeum/compare/7.5.0...7.6.0
[7.5.0]: https://github.com/aedart/athenaeum/compare/7.4.0...7.5.0
[7.4.0]: https://github.com/aedart/athenaeum/compare/7.3.0...7.4.0
[7.3.0]: https://github.com/aedart/athenaeum/compare/7.2.0...7.3.0
[7.2.0]: https://github.com/aedart/athenaeum/compare/7.1.0...7.2.0
[7.1.0]: https://github.com/aedart/athenaeum/compare/7.0.1...7.1.0
[7.0.1]: https://github.com/aedart/athenaeum/compare/7.0.0...7.0.1
[7.0.0]: https://github.com/aedart/athenaeum/compare/7.0.0-alpha.1...7.0.0
[7.0.0-alpha.1]: https://github.com/aedart/athenaeum/compare/7.0.0-alpha...7.0.0-alpha.1
[7.0.0-alpha]: https://github.com/aedart/athenaeum/compare/6.8.1...7.0.0-alpha
[6.8.1]: https://github.com/aedart/athenaeum/compare/6.8.0...6.8.1
[6.8.0]: https://github.com/aedart/athenaeum/compare/6.7.0...6.8.0
[6.7.0]: https://github.com/aedart/athenaeum/compare/6.6.0...6.7.0
[6.6.0]: https://github.com/aedart/athenaeum/compare/6.5.2...6.6.0
[6.5.2]: https://github.com/aedart/athenaeum/compare/6.5.1...6.5.2
[6.5.1]: https://github.com/aedart/athenaeum/compare/6.5.0...6.5.1
[6.5.0]: https://github.com/aedart/athenaeum/compare/6.4.0...6.5.0
[6.4.0]: https://github.com/aedart/athenaeum/compare/6.3.0...6.4.0
[6.3.0]: https://github.com/aedart/athenaeum/compare/6.2.1...6.3.0
[6.2.1]: https://github.com/aedart/athenaeum/compare/6.2.0...6.2.1
[6.2.0]: https://github.com/aedart/athenaeum/compare/6.1.1...6.2.0
[6.1.1]: https://github.com/aedart/athenaeum/compare/6.1.0...6.1.1
[6.1.0]: https://github.com/aedart/athenaeum/compare/6.0.2...6.1.0
[6.0.2]: https://github.com/aedart/athenaeum/compare/6.0.1...6.0.2
[6.0.1]: https://github.com/aedart/athenaeum/compare/6.0.0...6.0.1
[6.0.0]: https://github.com/aedart/athenaeum/compare/5.27.0...6.0.0
[5.27.0]: https://github.com/aedart/athenaeum/compare/5.26.0...5.27.0
[5.26.0]: https://github.com/aedart/athenaeum/compare/5.25.0...5.26.0
[5.25.0]: https://github.com/aedart/athenaeum/compare/5.24.2...5.25.0
[5.24.2]: https://github.com/aedart/athenaeum/compare/5.24.1...5.24.2
[5.24.1]: https://github.com/aedart/athenaeum/compare/5.24.0...5.24.1
[5.24.0]: https://github.com/aedart/athenaeum/compare/5.23.0...5.24.0
[5.23.0]: https://github.com/aedart/athenaeum/compare/5.22.4...5.23.0
[5.22.4]: https://github.com/aedart/athenaeum/compare/5.22.3...5.22.4
[5.22.3]: https://github.com/aedart/athenaeum/compare/5.22.2...5.22.3
[5.22.2]: https://github.com/aedart/athenaeum/compare/5.22.1...5.22.2
[5.22.1]: https://github.com/aedart/athenaeum/compare/5.22.0...5.22.1
[5.22.0]: https://github.com/aedart/athenaeum/compare/5.21.0...5.22.0
[5.21.0]: https://github.com/aedart/athenaeum/compare/5.20.0...5.21.0
[5.20.0]: https://github.com/aedart/athenaeum/compare/5.19.0...5.20.0
[5.19.0]: https://github.com/aedart/athenaeum/compare/5.18.1...5.19.0
[5.18.1]: https://github.com/aedart/athenaeum/compare/5.18.0...5.18.1
[5.18.0]: https://github.com/aedart/athenaeum/compare/5.17.0...5.18.0
[5.17.0]: https://github.com/aedart/athenaeum/compare/5.16.0...5.17.0
[5.16.0]: https://github.com/aedart/athenaeum/compare/5.15.0...5.16.0
[5.15.0]: https://github.com/aedart/athenaeum/compare/5.14.1...5.15.0
[5.14.1]: https://github.com/aedart/athenaeum/compare/5.14.0...5.14.1
[5.14.0]: https://github.com/aedart/athenaeum/compare/5.13.2...5.14.0
[5.13.2]: https://github.com/aedart/athenaeum/compare/5.13.1...5.13.2
[5.13.1]: https://github.com/aedart/athenaeum/compare/5.13.0...5.13.1
[5.13.0]: https://github.com/aedart/athenaeum/compare/5.12.0...5.13.0
[5.12.0]: https://github.com/aedart/athenaeum/compare/5.11.0...5.12.0
[5.11.0]: https://github.com/aedart/athenaeum/compare/5.10.1...5.11.0
[5.10.1]: https://github.com/aedart/athenaeum/compare/5.10.0...5.10.1
[5.10.0]: https://github.com/aedart/athenaeum/compare/5.9.0...5.10.0
[5.9.0]: https://github.com/aedart/athenaeum/compare/5.8.0...5.9.0
[5.8.0]: https://github.com/aedart/athenaeum/compare/5.7.0...5.8.0
[5.7.0]: https://github.com/aedart/athenaeum/compare/5.6.0...5.7.0
[5.6.0]: https://github.com/aedart/athenaeum/compare/5.5.1...5.6.0
[5.5.1]: https://github.com/aedart/athenaeum/compare/5.5.0...5.5.1
[5.5.0]: https://github.com/aedart/athenaeum/compare/5.4.0...5.5.0
[5.4.0]: https://github.com/aedart/athenaeum/compare/5.3.5...5.4.0
[5.3.5]: https://github.com/aedart/athenaeum/compare/5.3.4...5.3.5
[5.3.4]: https://github.com/aedart/athenaeum/compare/5.3.3...5.3.4
[5.3.3]: https://github.com/aedart/athenaeum/compare/5.3.2...5.3.3
[5.3.2]: https://github.com/aedart/athenaeum/compare/5.3.1...5.3.2
[5.3.1]: https://github.com/aedart/athenaeum/compare/5.3.0...5.3.1
[5.3.0]: https://github.com/aedart/athenaeum/compare/5.2.1...5.3.0
[5.2.1]: https://github.com/aedart/athenaeum/compare/5.2.0...5.2.1
[5.2.0]: https://github.com/aedart/athenaeum/compare/5.1.0...5.2.0
[5.1.0]: https://github.com/aedart/athenaeum/compare/5.0.2...5.1.0
[5.0.2]: https://github.com/aedart/athenaeum/compare/5.0.1...5.0.2
[5.0.1]: https://github.com/aedart/athenaeum/compare/5.0.0...5.0.1
[5.0.0]: https://github.com/aedart/athenaeum/compare/4.2.1...5.0.0
[4.2.1]: https://github.com/aedart/athenaeum/compare/4.2.0...4.2.1
[4.2.0]: https://github.com/aedart/athenaeum/compare/4.1.0...4.2.0
[4.1.0]: https://github.com/aedart/athenaeum/compare/4.0.1...4.1.0
[4.0.1]: https://github.com/aedart/athenaeum/compare/v4.0...4.0.1
[4.0.0]: https://github.com/aedart/athenaeum/compare/3.1.0...v4.0
[3.1.0]: https://github.com/aedart/athenaeum/compare/3.0.1...3.1.0
[3.0.1]: https://github.com/aedart/athenaeum/compare/3.0.0...3.0.1
[3.0.0]: https://github.com/aedart/athenaeum/compare/2.3.0...3.0.0
[2.3.0]: https://github.com/aedart/athenaeum/compare/2.2.0...2.3.0
[2.2.0]: https://github.com/aedart/athenaeum/compare/2.1.0...2.2.0
[2.1.0]: https://github.com/aedart/athenaeum/compare/2.0.0...2.1.0
[2.0.0]: https://github.com/aedart/athenaeum/compare/1.0.0...2.0.0
[1.0.0]: https://github.com/aedart/athenaeum/releases/tag/1.0.0
