---
description: About Array Exporter
sidebarDepth: 0
---

# Array

**Driver**: `\Aedart\Translation\Exports\Drivers\ArrayExporter`

Exports registered translations to an array.

```php
$translations = $manager
    ->profile('array')
    ->export('en', [ 'auth', 'acme::users' ]);

print_r($translations);
```

The output format looks similar to the following:

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
            [acme::users] => Array
                (
                    [greetings] => Comrades are the cannons of the weird halitosis.
                    [messages] => Array
                        (
                            [a] => Spacecrafts meet with ellipse!
                            [b] => Uniqueness is the only samadhi, the only guarantee of solitude.
                            [c] => Ho-ho-ho! punishment of beauty.
                        )
                )
        )
)
```