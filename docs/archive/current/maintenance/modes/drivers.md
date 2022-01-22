---
description: Available Maintenance Mode Drivers
---

# Available Drivers

[[TOC]]

## Array

The `'array'` maintenance mode driver uses an in-memory array to store the applications down state.
This driver is ONLY useful for testing and _SHOULD NOT_ be used within a production environment.

```php
$mode = $this->getMaintenanceModeManager()->driver('array');
```

Driver path: `\Aedart\Maintenance\Modes\Drivers\ArrayBasedMode`

## Json

The `'json'` maintenance mode driver is very similar to Laravel's default "file based" driver. It stores the application down state inside a file, formatted as json.
Only difference is that this driver will fail, in case of json encoding or decoding errors.

```php
$mode = $this->getMaintenanceModeManager()->driver('json');
```

Driver path: `\Aedart\Maintenance\Modes\Drivers\JsonFileBasedMode`
