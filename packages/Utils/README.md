# Athenaeum Utils

This package offers a few utility components.
They are used throughout many of the Athenaeum packages, yet you can choose to make use of them, as you see fit.

## Example

```php
use Aedart\Utils\Json;
use Aedart\Utils\Version;

// Obtain version of installed package
$version = Version::package('aedart/athenaeum-utils');

// Json encode ~ throw exception if encoding fails
echo Json::encode([
    'version' => $version
]);
```

## Documentation

Please read the [official documentation](https://aedart.github.io/athenaeum/) for additional information.

## Repository

The mono repository is located at [github.com/aedart/athenaeum](https://github.com/aedart/athenaeum)

## Versioning

This package follows [Semantic Versioning 2.0.0](http://semver.org/)

## License

[BSD-3-Clause](http://spdx.org/licenses/BSD-3-Clause), Read the LICENSE file included in this package
