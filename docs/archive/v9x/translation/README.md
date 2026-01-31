---
description: About the Translation package
---

# Introduction

The translation package contains a few utilities for [Laravel's Localization utilities](https://laravel.com/docs/12.x/localization).

## Exporters

Among the available utilities are [translation exporters](./exporters/README.md).

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