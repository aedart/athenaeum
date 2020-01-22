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
* change IoC register main bindings - should NOT conflict with Laravel's Service Container, unless called explicitly!
* change Http Client interface to adhere to the PSR-18 (Http Client) interface!

### [v4.0.0](__TODO__)

#### Changed

**Breaking Changes**

* PHP version from `v7.3.x` to `v7.4.x`.
* All class properties now have their [types declared](https://www.php.net/manual/en/migration74.new-features.php#migration74.new-features.core.typed-properties), if possible.
* `dto:create-aware-of` command now generates traits with class [type declarations](https://www.php.net/manual/en/migration74.new-features.php#migration74.new-features.core.typed-properties) for it's properties.
* `Dto` and `ArrayDto` now implement the `__serialize()` and `__unserialize()` magic methods.
* Replaced `\Aedart\Dto` with `\Aedart\Dto\Dto`[1].
* Replaced `\Aedart\ArrayDto` with `\Aedart\Dto\ArrayDto`[1].
* `Faker`, `Mockery`, `Codeception` and `Orchestra Testbench` are now defined as dev-dependencies.
You need to require these packages, if you depended on these packages[2].

[1]: _Deprecation of existing abstractions or components is due to the conversion of this package into a [mono repository](ttps://en.wikipedia.org/wiki/Monorepo).
Existing abstractions are still available, yet will be removed entirely in `v5.0`_

[2]: _You can require [`aedart/athenaeum-testing`](https://packagist.org/packages/aedart/athenaeum-testing) as dev-dependency and the mentioned packages will all be installed._

**Non-breaking Changes**

* Converted athenaeum into a true [mono repository](ttps://en.wikipedia.org/wiki/Monorepo). All major components are now available as separate packages, via composer.
* Upgraded to Laravel `v6.12.x`, Symfony `v4.4.x` and upgraded various other dependencies.
* Code style to [PSR-12](https://www.php-fig.org/psr/psr-12/).
* Replaced deprecated `Twig` components, in `TwigPartial` trait.
* `UnitTestCase` now uses `FakerPartial` to setup [Faker](https://github.com/fzaninotto/Faker).
* Using `IoCFacade` to resolve default Http Client `Manager`, in `HttpClientsManagerTrait`.
* Added `\Aedart\Contracts\Container\IoC` and `\Illuminate\Contracts\Container\Container` as `app` binding aliases, in `IoC`. 

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

#### Fixed

* `Applicaiton` instance not destroyed after `stopApplication()` invoked, in `ApplocationInitiator`.
This resulting in `$instance` still containing reference to the application, inside Laravel's Service Container, causing tests to fail.
* `destroy()` does not flush bindings, in `IoC`. Instance is destroyed, yet formal Service Container `flush()` was not respected.
* Default values not triggered when invoking `toArray()`, in `Dto` and `ArrayDto`, when using aware-of traits to create a Dto class.
* Missing Psr `ContainerInterface` alias binging for the custom `IoC`;
* `$instance` not set if `IoC` was created via constructor, instead of `getInstance()`.



