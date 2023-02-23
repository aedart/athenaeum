# Athenaeum Translation

The translation package contains a few utilities for [Laravel's Localization utilities](https://laravel.com/docs/10.x/localization).

## Exporters

Among the available utilities are translation exporters.

```php
$translations = $exporter->export('en', 'auth');

print_r($translations);
```

```
Array
(
    [en] => Array
        (
            [__JSON__] => Array
                (
                    [The :attribute must contain one letter.] => The :attribute must contain one letter.
                )
            [auth] => Array
                (
                    [failed] => These credentials do not match our records.
                    [password] => The provided password is incorrect.
                    [throttle] => Too many login attempts. Please try again in :seconds seconds.
                )
        )
)
```

## Documentation

Please read the [official documentation](https://aedart.github.io/athenaeum/) for additional information.

## Repository

The mono repository is located at [github.com/aedart/athenaeum](https://github.com/aedart/athenaeum)

## Versioning

This package follows [Semantic Versioning 2.0.0](http://semver.org/)

## License

[BSD-3-Clause](http://spdx.org/licenses/BSD-3-Clause), Read the LICENSE file included in this package
