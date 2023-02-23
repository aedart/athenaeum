---
description: About Lang.js (Json) Exporter
sidebarDepth: 0
---

# Lang.js (JSON)

**Driver**: `\Aedart\Translation\Exports\Drivers\LangJsJsonExporter`

This exporter allows you to export JSON encoded translations for [lang.js](https://github.com/rmariuzzo/Lang.js).

```php
$translations = $manager
    ->profile('array')
    ->export('en', [ 'auth', 'acme::users' ]);

print_r($translations);
```

```json
{
  "en.__JSON__": {
    "ok": "Nice, mate!"
  },
  "en.auth": {
    "failed": "These credentials do not match our records.",
    "password": "The provided password is incorrect.",
    "throttle": "Too many login attempts. Please try again in :seconds seconds."
  },
  "en.translation-test::users": {
    "greetings": "Comrades are the cannons of the weird halitosis.",
    "messages": {
      "a": "Spacecrafts meet with ellipse!",
      "b": "Uniqueness is the only samadhi, the only guarantee of solitude.",
      "c": "Ho-ho-ho! punishment of beauty."
    }
  }
}
```