# Athenaeum Cookies

Provides very simple [DTOs](https://en.wikipedia.org/wiki/Data_transfer_object) for [Http Cookie](https://en.wikipedia.org/wiki/HTTP_cookie).
These DTOs are nothing more than data placeholders; they do not offer "advanced" capabilities.
Feel free to extend them with whatever logic your application might require.

## Examples

```php
<?php
use Aedart\Http\Cookies\Cookie;

$cookie = new Cookie([
    'name' => 'my_cookie',
    'value' => 'sweet'
]);
```

```php
<?php
use Aedart\Http\Cookies\SetCookie;

$cookie = new SetCookie([
    'name' => 'my_cookie',
    'value' => 'sweet',
    'maxAge' => 60 * 5,
    'secure' => true
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
