# Release Notes

## v2.x

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