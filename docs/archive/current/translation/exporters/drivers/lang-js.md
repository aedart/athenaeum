---
description: About Lang.js Exporter
sidebarDepth: 0
---

# Lang.js (Array)

**Driver**: `\Aedart\Translation\Exports\Drivers\LangJsExporter`

If you are using [lang.js](https://github.com/rmariuzzo/Lang.js), then you can use this exporter to create an array,
that is formatted according to the [desired message format](https://github.com/rmariuzzo/Lang.js#messages-source-format).

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
    [en.__JSON__] => Array
        (
            [ok] => Nice, mate!
        )
    [en.auth] => Array
        (
            [failed] => These credentials do not match our records.
            [password] => The provided password is incorrect.
            [throttle] => Too many login attempts. Please try again in :seconds seconds.
        )
    [en.translation-test::users] => Array
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
```