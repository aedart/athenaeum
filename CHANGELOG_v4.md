# Release Notes

**Note**: _this is a working document that will be removed, as soon as this major version is ready for release!_

## v4.x

// TODO:
* added custom application
* added application integration test-case
* Split docs into version 3.x and 4.x
* docs about custom application, etc.
* docs about custom event service provider
* docs about custom exception handling
* docs about logging using custom application
* change Http Client interface to adhere to the PSR-18 (Http Client) interface!
* docs about version util
* change `docs` location for aware-of properties (`properties.php`), so that current v3.x are not overwritten! 

### [v4.0.0](__TODO__)

#### Changed

**Breaking Changes**

* PHP version from `v7.3.x` to `v7.4.x`.
* All class properties now have their [types declared](https://www.php.net/manual/en/migration74.new-features.php#migration74.new-features.core.typed-properties), if possible.
* `dto:create` command now generates traits with class [type declarations](https://www.php.net/manual/en/migration74.new-features.php#migration74.new-features.core.typed-properties) for it's properties (_former `dto:create-aware-of` command_).
* `Dto` and `ArrayDto` now implements the `__serialize()` and `__unserialize()` magic methods.
* Replaced `\Aedart\Dto` with `\Aedart\Dto\Dto`[1].
* Replaced `\Aedart\ArrayDto` with `\Aedart\Dto\ArrayDto`[1].
* [Codeception](https://github.com/Codeception/Codeception) and [Orchestra Testbench](https://github.com/orchestral/testbench) are now defined as dev-dependencies.
You need to require these packages, if you depended on them[2].
* (_Fix_) `IoC` no longer highjacks Laravel's `app` binding automatically, when `getInstance()` is invoked.
This was used to get some of Laravel's components to work outside the scope of a Laravel application.
Yet, this was a kinda a hack that wasn't intended[3].
* Deprecated `\Aedart\Console\CommandBase`, `\Aedart\Console\AwareOfScaffoldCommand` and `\Aedart\Console\CreateAwareOfCommand` components.
Commands have been replaced with updated versions within the [`aedart/athenaeum-support `](https://packagist.org/packages/aedart/athenaeum-support) package.
The original commands are still available using the `athenaeum` console application.

**Non-breaking Changes**

* Converted athenaeum into a true [mono repository](ttps://en.wikipedia.org/wiki/Monorepo). All major components are now available as separate packages, via composer.
* Upgraded to Laravel `v6.12.x`, Symfony `v4.4.x` and upgraded various other dependencies.
* Code style to [PSR-12](https://www.php-fig.org/psr/psr-12/).
* Replaced deprecated `Twig` components, in `TwigPartial` trait.
* `UnitTestCase` now uses `FakerPartial` to setup [Faker](https://github.com/fzaninotto/Faker).
* Using `IoCFacade` to resolve default Http Client `Manager`, in `HttpClientsManagerTrait`.
* Added `\Aedart\Contracts\Container\IoC` and `\Illuminate\Contracts\Container\Container` as `app` binding aliases, in `IoC`[3].
* Added possibility to specify specific `vendor` and `output` paths for `interfaces` and `traits`, in the aware-of `Generator`. 

[1]: _Deprecation of existing abstractions or components is due to the conversion of this package into a [mono repository](ttps://en.wikipedia.org/wiki/Monorepo).
Existing abstractions are still available, yet will be removed entirely in `v5.0`._

[2]: _You can require packages separately or if you only use the "testing" components, then replace this package with [`aedart/athenaeum-testing`](https://packagist.org/packages/aedart/athenaeum-testing) as dev-dependency and the mentioned packages will all be installed._

[3]: _You have to invoke `registerAsApplication()` explicitly to bind the `IoC` instance as `app`, should you require this during testing or outside a Laravel application.
**Warning**: do NOT invoke mentioned method if you are using the `IoC` within a Laravel application.
It will highjack the `app` binding, which will cause your application to behave unfavourable._

#### Added

* `Application`, custom adaptation of Laravel's Application.
* `Registrar`, able to register service providers.
* `IoCFacade`, able to resolve bindings or return a default value, if binding does not exist.
* `ListenersViaConfigServiceProvider`, offers registration of event listeners and subscribers via configuration.
* `BaseExeptionHandler` abstraction along with a few default exception handlers that can be used with `Application`, if enabled.
* `FakerAware` component that can be used for testing purposes.
* `FakerPartial`, offers basic setup for [Faker](https://github.com/fzaninotto/Faker).
* `callOrReturn()` utility method in `MethodHelper`.
* `MessageBag` testing component. Intended to store test or debugging messages across components and tests.
* `Version` utility. 
* `string` and `int` `Milestone` aware components

#### Fixed

* `Applicaiton` instance not destroyed after `stopApplication()` invoked, in `ApplocationInitiator`.
This resulting in `$instance` still containing reference to the application, inside Laravel's Service Container, causing tests to fail.
* `destroy()` does not flush bindings, in `IoC`. Instance is destroyed, yet formal Service Container `flush()` was not respected.
* Default values not triggered when invoking `toArray()`, in `Dto` and `ArrayDto`, when using aware-of traits to create a Dto class.



