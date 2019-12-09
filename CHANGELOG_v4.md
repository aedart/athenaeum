# Release Notes

**Note**: _this is a working document, to be removed again, once this major version is ready for release!_

## v4.x

### [v4.0.0](__TODO__)

#### Changed

**Breaking Changes**

* PHP version from `v7.3.x` to `v7.4.x`.
* All class properties now have their [types declared](https://www.php.net/manual/en/migration74.new-features.php#migration74.new-features.core.typed-properties), if possible.
* `dto:create-aware-of` command now generates traits with class [type declarations](https://www.php.net/manual/en/migration74.new-features.php#migration74.new-features.core.typed-properties) for it's properties.
* `Dto` and `ArrayDto` now implement the `__serialize()` and `__unserialize()` magic methods.
* Replaced `\Aedart\Dto` with `\Aedart\Dto\Dto`[1].
* Replaced `\Aedart\ArrayDto` with `\Aedart\Dto\ArrayDto`[1].

[1]: _Deprecation of existing abstractions is due to future possibility of converting the athenaeum package into a true mono-repository, containing multiple packages.
Existing abstractions are still available, yet will be removed entirely in `v5.0`._

**Non-breaking Changes**

* Upgraded to Laravel `v6.6.x`, Symfony `v4.4.x` and upgraded various other dependencies.
* Code style to [PSR-12](https://www.php-fig.org/psr/psr-12/).
* Replaced deprecated `Twig` components, in `TwigPartial` trait.
* `UnitTestCase` now uses `FakerPartial` to setup [Faker](https://github.com/fzaninotto/Faker).
* Using `IoCFacade` to resolve default Http Client `Manager`, in `HttpClientsManagerTrait`.
* Added `\Aedart\Contracts\Container\IoC` and `\Illuminate\Contracts\Container\Container` as `app` binding aliases, in `IoC`. 

#### Added

* `IoCFacade`, able to resolve bindings or return a default value, if binding does not exist.
* `FakerAware` component that can be used for testing purposes.
* `FakerPartial`, offers basic setup for [Faker](https://github.com/fzaninotto/Faker).
* `callOrReturn()` utility method in `MethodHelper`.

#### Fixed

* `Applicaiton` instance not destroyed after `stopApplication()` invoked, in `ApplocationInitiator`.
This resulting in `$instance` still containing reference to the application, inside Laravel's Service Container, causing tests to fail.
* `destroy()` does not flush bindings, in `IoC`. Instance is destroyed, yet formal Service Container `flush()` was not respected.



