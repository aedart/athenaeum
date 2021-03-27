# Release Notes

## v5.x

### [Unreleased]

#### Added

* Documentation for the validation package. [#38](https://github.com/aedart/athenaeum/issues/38).
* Documentation for the database package. [#36](https://github.com/aedart/athenaeum/issues/36).

### [v5.10.1](https://github.com/aedart/athenaeum/compare/5.10.0...5.10.1)

#### Fixed

* Fix ACL models not respecting database connection in transactions. In situations when a custom connection was set or resolved, the ALC Permissions `Group` and `Role` didn't use that given connection in their custom creation or update methods.  

### [v5.10.0](https://github.com/aedart/athenaeum/compare/5.9.0...5.10.0)

#### Added

* Several tests to verify behaviour of `Slugs` concern, in Database package. [#39](https://github.com/aedart/athenaeum/issues/39).
* `createWithPermissions()` and `updateWithPermissions()` helper methods in ACL `Role` Eloquent model. [#41](https://github.com/aedart/athenaeum/pull/41).

#### Changed

* Removed unnecessary `$slug` merge into `$values` parameter in `Slugs::findOrCreateBySlug`, in Database package. [#40](https://github.com/aedart/athenaeum/pull/40).
* Replaced manual transaction rollback handling in `createWithPermissions()` method, inside ACL Permissions `Group` model. Now using Laravel's `DB::transaction()` method instead. [#41](https://github.com/aedart/athenaeum/pull/41).

### [v5.9.0](https://github.com/aedart/athenaeum/compare/5.8.0...5.9.0)

#### Added

* Validation package that is intended to offer various rules and other validation related utilities. Presently, it only contains an `AlphaDashDot` rule. [#37](https://github.com/aedart/athenaeum/pull/37).

### [v5.8.0](https://github.com/aedart/athenaeum/compare/5.7.0...5.8.0)

#### Added

* ACL package which offers a way to store roles and permissions (grouped) in a database. [#34](https://github.com/aedart/athenaeum/pull/34).
* Database utilities package. [#34](https://github.com/aedart/athenaeum/pull/34).
* `Sluggable` interface and `Slug` concern in new Database package.
* `Str` utility, which offers a few additional string manipulation methods.

#### Fixed

* Unable to run database migrations via `LaravelTestCase`. Now implements `\Orchestra\Testbench\Contracts\TestCase`, which resolves the issue¹.

¹: _Orchestra's `MigrateProcessor` component, which is used behind the scene, has an explicit `TestCase` dependency. This cannot be circumvented without extensive overwrites of several migration helper methods._

### [v5.7.0](https://github.com/aedart/athenaeum/compare/5.6.0...5.7.0)

#### Added

* `application()` method in `\Aedart\Utils\Version`, which is able to return application's version. [#25](https://github.com/aedart/athenaeum/issues/25)

#### Fixed

* Too many Chrome driver processes started in `BrowserTestCase`, possibly causing a `Connection Refused` error. [#33](https://github.com/aedart/athenaeum/issues/33)

### [v5.6.0](https://github.com/aedart/athenaeum/compare/5.5.1...5.6.0)

#### Added

* Collections package, with `Summation` and `ItemProcessor` components. [#27](https://github.com/aedart/athenaeum/issues/27) 
* `undot()` method in `Arr` utility.

### [v5.5.1](https://github.com/aedart/athenaeum/compare/5.5.0...5.5.1)

#### Fixed

* Incorrect teardown order in `BrowserTestCase`

### [v5.5.0](https://github.com/aedart/athenaeum/compare/5.4.0...5.5.0)

#### Fixed

* Facade root not set during test teardown, in `LaravelTestCase` and `ApplicationInitiator`¹.
* Laravel's `Application` still bound as `IoC`'s static instance, causing strange behaviour in some tests². 

¹: _The happened sometime after Laravel released the "parallel testing" feature and Orchestra Testbench enabled it._
²: _Unintended side effect of fixing the `ApplicationInitiator`._

#### Changed

* Bumped license year, in `LICENSE` files.
* Minimum required [Orchestra Testbench](https://packagist.org/packages/orchestra/testbench) set to `v6.12.x`.

### [v5.4.0](https://github.com/aedart/athenaeum/compare/5.3.5...5.4.0)

#### Changed

* `ApplicationInitiator` now makes use of custom `LoadSpecifiedConfiguration`.
  A previously added, but not applied specialisation of Orchetra `LoadConfiguration`.
  Custom component allows specifying the location of configuration files to be loaded, via `getBasePath()` and `getConfigPath()` methods*.  

*: _This change will implicit ensure that changes to `LoadConfiguration` will be caught by tests and thereby prevent defects that resulted in patches `v5.3.3` to `v5.3.5`._

### [v5.3.5](https://github.com/aedart/athenaeum/compare/5.3.4...5.3.5)

#### Fixed

* Incorrect format yield from `getConfigurationFiles` method, in `LoadSpecifiedConfiguration` Testing utility*.

*: _Was in a hurry to fix a "minor" defect, which just caused several other minor defects._

### [v5.3.4](https://github.com/aedart/athenaeum/compare/5.3.3...5.3.4)

#### Fixed

* `getConfigurationFiles` method still returned `array` instead of specified `Generator`, in `LoadSpecifiedConfiguration` Testing utility.

### [v5.3.3](https://github.com/aedart/athenaeum/compare/5.3.2...5.3.3)

#### Fixed

* Incorrect return type for `getConfigurationFiles` method, in `LoadSpecifiedConfiguration` Testing utility.

### [v5.3.2](https://github.com/aedart/athenaeum/compare/5.3.1...5.3.2)

#### Fixed

* Boundary values incorrectly shown when using `toHoursMinutes()` and `toMinutesSeconds()`, in `Duration` utility. 

E.g. when attempting to convert -2700 seconds to hours and minutes, the `toHoursMinutes()` method return 00:45, instead of -00:45.

### [v5.3.1](https://github.com/aedart/athenaeum/compare/5.3.0...5.3.1)

#### Fixed

* `toHoursMinutes()` not able to show above 24 hours, in `Duration` utility.
* `toMinutesSeconds()` not able to show above 60 minutes, in `Duration` utility.

Both methods failed showing a correct amount, whenever the initial value surpassed 24 hours (_or 60 minutes for `toMinutesSeconds()`_).

### [v5.3.0](https://github.com/aedart/athenaeum/compare/5.2.1...5.3.0)

#### Added

* `fromHoursMinutes` and `fromStringHoursMinutes` methods in `Duration` utility.

#### Changed

* Laravel `v8.15.x` packages are now required as a minimum.
* Updated [Orchesta Testbench](https://github.com/orchestral/testbench-core) dependencies to `v6.9.x`.
* Added leading zero for `Durataion::toHoursMinutes` short format.
* Disabled `failsIfCacheIsNotLockProvider` test, since botch file and null cache drivers [now support locks](https://github.com/laravel/framework/blob/8.x/CHANGELOG-8.x.md#v8150-2020-11-17).

### [v5.2.1](https://github.com/aedart/athenaeum/compare/5.2.0...5.2.1)

#### Fixed

* Invalid `$this` reference in `static function`, in `DuskTestHelper`.
* Call to unknown `makeChromeOptions()` method.

### [v5.2.0](https://github.com/aedart/athenaeum/compare/5.1.0...5.2.0)

#### Added

* `LoadSpecifiedConfiguration` bootstrapper, in `Testing` package. Intended for Laravel and Laravel Dusk tests.
* `$browserSourceOutput` property. Location where a page's source code is to be stored, in `DuskTestHelper`. 

#### Changed

* Switched back to `ChromeOptions::CAPABILITY` (_which is deprecated_), because `ChromeOptions::CAPABILITY_W3C` ignores command line arguments for Chrome Driver, in `DuskTestHelper`. 
* Extracted configuration loader binding into own method / property, in `DuskTestHelper`. This makes it easier to overwrite, when needed.

### [v5.1.0](https://github.com/aedart/athenaeum/compare/5.0.2...5.1.0)

#### Added

* Added `DuskTestHelper` and `BrowserTestCase` helpers, which offers integration to [Laravel Dusk](https://laravel.com/docs/8.x/dusk).

#### Changed

* Changed `LaravelTestHelper`, added `InteractsWithTime` ([Laravel's helper](https://laravel.com/docs/8.x/mocking#interacting-with-time)) and `InteractsWithViews`. [#20](https://github.com/aedart/athenaeum/issues/20).

### [v5.0.2](https://github.com/aedart/athenaeum/compare/5.0.1...5.0.2)

#### Fixed

* Incorrect code style caused CI failure.

### [v5.0.1](https://github.com/aedart/athenaeum/compare/5.0.0...5.0.1)

#### Fixed 

* Http Message stream not rewound after serialization, when using `debug()`, `dd()` or `log()`. See [#19](https://github.com/aedart/athenaeum/issues/19) for details. 
* Removed deprecated `CreateAwareOfCommand` reference from `athenaeum` console application. 
* Fixed a few typos.

### [v5.0.0](https://github.com/aedart/athenaeum/compare/4.2.1...5.0.0)

#### Added

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

#### Changed

**Breaking Changes**

* Upgraded Laravel dependencies to `v8.x`.
* Added `bootstrap()` method in `\Aedart\Core\Console\Kernel`, due to Laravel's Console `Kernal` interface change. `runCore()` method will now invoke new bootstrap method.
* `getExpectations()` now returns array of `ResponseExpectation` instances, in Request `Builder`.
* Changed `StatusCodesExpectation`, now inherits from `ResponseExpectation`. Some internal methods have been redesigned. This change should not affect your code, unless you have custom Http Request `Builder` implementation.
* Changed `withExpectation()`, in Request `Builder`. Now accepts both a `callable` and a `ResponseExpectation` instance. This change should not affect your code, unless you have custom Http Request `Builder` implementation.
* Changed Request `Builder` and Http `Client` interfaces and concrete implementations. Now offers methods for adding `Middleware`. This change only affects you if you have a custom Http `Client` or Request `Builder` implementation.
* Changed Http `Client` and Request `Builder`, added debugging methods (`debug()`, `dd()`, `log()`...etc). This change only affects you if you have a custom Http `Client` or Request `Builder` implementation.
* Removed `Aedart\Dto` (_was deprecated in `v4.x`_).
* Removed `Aedart\ArrayDto` (_was deprecated in `v4.x`_).
* Removed `Aedart\Console\CreateAwareOfCommand` (_was deprecated in `v4.x`_).
* Removed `Aedart\Console\CommandBase` (_was deprecated in `v4.x`_).
* Removed `Aedart\Console\AwareOfScaffoldCommand` (_was deprecated in `v4.x`_).
* Removed all helpers in `Aedart\Support\Properties\Mixed\*` namespace (_was deprecated in `v4.x`_).
* Removed all contracts in `Aedart\Contracts\Support\Properties\Mixed\*` namespace (_was deprecated in `v4.x`_).

**Non-breaking Changes**

* Added shortcut methods (_`getClient()` and `client()`_) for obtaining Http Client instance in `ProcessOptions`. 
* Removed internal `applyExpectations()` method from `Expectations` concern, in Http Client `Builder`. Has been replaced by `AppliesResponseExpectations` middleware.
* Changed `HttpClientServiceProvider`, now inherits from the `AggregateServiceProvider` and registers the `HttpSerializationServiceProvider` automatically. This eliminates setup of debugging components, for the Http `Client`.

#### Fixed

* Fixed incorrect type declarations in PHPDoc (_throughout various components_). 
* Codeception broken after update (_in codeception version 4.1.x series_).

## v4.x

### [v4.2.1](https://github.com/aedart/athenaeum/compare/4.2.0...4.2.1)

* Bumped minimum required dependencies, due to [security issue / release from Laravel](https://blog.laravel.com/laravel-cookie-security-releases).

### [v4.2.0](https://github.com/aedart/athenaeum/compare/4.1.0...4.2.0)

#### Added

* Circuits package that offers a `CircuitBreaker`, with a `Manager` (profile-based).

### [v4.1.0](https://github.com/aedart/athenaeum/compare/4.0.1...4.1.0)

#### Fixed

* (Core) Unable to run `schedule:run` command. [#10](https://github.com/aedart/athenaeum/issues/10)

#### Changed

* Minimum required Laravel packages version set to version `^7.7`

#### Added

* `LaravelExceptionHandler` adaptor

### [v4.0.1](https://github.com/aedart/athenaeum/compare/v4.0...4.0.1)

#### Fixed

* Broken inter-dependencies in all packages. Removed version `v4.0` from packagist.org to prevent conflicts. 

### [v4.0.0](https://github.com/aedart/athenaeum/compare/3.1.0...v4.0)

#### Changed

**Breaking Changes**

* Required PHP version changed to `v7.4.x`.
* Upgraded Laravel dependencies to `v7.6.x`, Symfony to `v5.0.x`, Codeception to `v4.1.x`, and various other dependencies.
* All class properties now have their [types declared](https://www.php.net/manual/en/migration74.new-features.php#migration74.new-features.core.typed-properties), if possible.
* `dto:create` command now generates traits with class [type declarations](https://www.php.net/manual/en/migration74.new-features.php#migration74.new-features.core.typed-properties) for it's properties (_former `dto:create-aware-of` command_).
* `Dto` and `ArrayDto` now implements the `__serialize()` and `__unserialize()` magic methods.
* Replaced `\Aedart\Dto` with `\Aedart\Dto\Dto`[1].
* Replaced `\Aedart\ArrayDto` with `\Aedart\Dto\ArrayDto`[1].
* [Codeception](https://github.com/Codeception/Codeception) and [Orchestra Testbench](https://github.com/orchestral/testbench) are now defined as dev-dependencies.
You need to require these packages, if you depended on them[2].
* (_Fix_) `IoC` no longer highjacks Laravel's `app` binding automatically, when `getInstance()` is invoked.
This was used to get some of Laravel's components to work outside the scope of a Laravel application.
Yet, this was a "hack" that potentially could lead to conflicted with Laravel. This was never intended[3]!
* Deprecated `\Aedart\Console\CommandBase`, `\Aedart\Console\AwareOfScaffoldCommand` and `\Aedart\Console\CreateAwareOfCommand` components.
Commands have been replaced with updated versions within the [`aedart/athenaeum-support `](https://packagist.org/packages/aedart/athenaeum-support) package.
The original commands are still available using the `athenaeum` console application.
* Redesign entire Http `Client` package, now makes use of a Request Builder and Http Query Builder.
* Deprecated all aware-of helpers that contained `*\Mixed\*` in their namespace.
These will be removed in next major version.
Replacement components are available within the `*\Mixes\*` namespace.
The term `Mixed` has been a [soft-reserved keyword](https://www.php.net/manual/en/reserved.other-reserved-words.php) since PHP `v7.0`.

**Non-breaking Changes**

* Converted athenaeum into a true [mono repository](ttps://en.wikipedia.org/wiki/Monorepo). All major components are now available as separate packages, via composer.
* Code style to [PSR-12](https://www.php-fig.org/psr/psr-12/).
* Replaced deprecated `Twig` components, in `TwigPartial` trait.
* `UnitTestCase` now uses `FakerPartial` to setup [Faker](https://github.com/fzaninotto/Faker).
* `UnitTestCase` now inherits from Codeception's `Unit` test-case.
* Using `IoCFacade` to resolve default Http Client `Manager`, in `HttpClientsManagerTrait`.
* Added `\Aedart\Contracts\Container\IoC` and `\Illuminate\Contracts\Container\Container` as `app` binding aliases, in `IoC`[3].
* Added possibility to specify specific `vendor` and `output` paths for `interfaces` and `traits`, in the aware-of `Generator`. 
* `getHeader()` is now case-insensitive, in `DefaultHttpClient` and `JsonHttpClient`.
Handling of headers is now more inline with [PSR-7](https://www.php-fig.org/psr/psr-7/#12-http-headers).
* Added `data_format` option for Http Clients.

[1]: _Deprecation of existing abstractions or components is due to the conversion of this package into a [mono repository](ttps://en.wikipedia.org/wiki/Monorepo).
Existing abstractions are still available, yet will be removed entirely in `v5.0`._

[2]: _You can require packages separately or if you only use the "testing" components, then replace this package with [`aedart/athenaeum-testing`](https://packagist.org/packages/aedart/athenaeum-testing) as dev-dependency and the mentioned packages will all be installed._

[3]: _You have to invoke `registerAsApplication()` explicitly to bind the `IoC` instance as `app`, should you require this during testing or outside a Laravel application.
**Warning**: do NOT invoke mentioned method if you are using the `IoC` within a Laravel application.
It will highjack the `app` binding, which will cause your application to behave unfavourable._

#### Added

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

#### Fixed

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

## v3.x

### [v3.1.0](https://github.com/aedart/athenaeum/compare/3.0.1...3.1.0)

#### Changed

* Updated license

### [v3.0.1](https://github.com/aedart/athenaeum/compare/3.0.0...3.0.1)

#### Fixed

* `LogicalException` thrown during travis build (_tests only_), caused by `PhpRedisConnector`. Changed test to use `predis` as default laravel redis connection.

### [v3.0.0](https://github.com/aedart/athenaeum/compare/2.3.0...3.0.0)

#### Changed

**Breaking Changes**

* Upgraded to Laravel `v6.x`, Symfony `v4.3.x` and upgraded various other dependencies.
* Removed custom `JsonException` (_deprecated_), in `Json` utility. Now defaults to php's native [`JsonException`](https://www.php.net/manual/en/class.jsonexception.php).

**Non-breaking Changes**

* Added `InteractsWithRedis` helper trait to the `LaravelTestHelper`.

## v2.x

### [v2.3.0](https://github.com/aedart/athenaeum/compare/2.2.0...2.3.0)

#### Changed

* Now supporting Symfony Console version 4.3.x, [#2](https://github.com/aedart/athenaeum/issues/2)

### [v2.2.0](https://github.com/aedart/athenaeum/compare/2.1.0...2.2.0)

#### Added

* Http Client package, a wrapper for the [Guzzle Http Client](http://docs.guzzlephp.org/en/stable/index.html), offering multiple "profile" based client instances, which can be configured via a `configs/http-clients.php` configuration file.

#### Changed

* Upgraded to codeception `v3.0.x` (_dev dependency_) and replaced deprecated assertions.

### [v2.1.0](https://github.com/aedart/athenaeum/compare/2.0.0...2.1.0)

#### Changed

* Simplified the bitmask operation for the `\Aedart\Utils\Json`.

### [v2.0.0](https://github.com/aedart/athenaeum/compare/1.2.0...2.0.0)

#### Changed

* Minimum required PHP version set to `v7.3.0`
* Main dependencies changed to Laravel `v5.8.x`, Symfony `v4.2.x` and Orchestra Testbench `v.3.8.x`
* `\Aedart\Utils\Json` automatically sets [`JSON_THROW_ON_ERROR`](http://php.net/manual/en/json.constants.php) bitmask option, if not set
* Deprecated `Aedart\Utils\Exceptions\JsonEncoding`. Use native [`JsonException`](http://php.net/manual/en/class.jsonexception.php) instead
* `Aedart\Utils\Exceptions\JsonEncoding` now inherits from [`JsonException`](http://php.net/manual/en/class.jsonexception.php)
* Deprecated `\Aedart\Contracts\Utils\Exceptions\JsonEncodingException`, will be removed in next major version
* Replaced deprecated `PHPUnit_Framework_MockObject_MockObject` with new `\PHPUnit\Framework\MockObject\MockObject`, in `TraitTester`

## v1.x

* Please review commits on [GitHub](https://github.com/aedart/athenaeum/commits/master)
