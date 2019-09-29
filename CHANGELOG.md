# Release Notes

## v3.x

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
