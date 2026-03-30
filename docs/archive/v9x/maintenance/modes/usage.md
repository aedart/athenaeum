---
description: How to use Maintenance Modes
---

# Basic Usage

[[TOC]]

## Switch Maintenance Mode Driver

By default, Laravel uses a "file based" maintenance mode. This means that each time you invoke `php artisan down`, a `down` file is created inside your application storage, e.g. `storage/framework/down`.
The application checks if this file exists and prevents, amongst other things, http requests from proceeding.

If you wish to change the maintenance mode "driver", you could do so via a custom service provider.

### Custom Service Provider

Inside your application, create and register a service provider that replaces the default bound `\Illuminate\Contracts\Foundation\MaintenanceMode`, with another driver.

```php
<?php

namespace Acme\Providers;

use Aedart\Maintenance\Modes\Traits\MaintenanceModeManagerTrait;
use Illuminate\Contracts\Foundation\MaintenanceMode;
use Illuminate\Support\ServiceProvider;

class SwitchMaintenanceMode extends ServiceProvider
{
    use MaintenanceModeManagerTrait;

    public function register()
    {
        // Overwrite Laravel's default maintenance mode driver...
        $this->app->bind(
            MaintenanceMode::class,
            fn() => $this->getMaintenanceModeManager()->driver('json')
        );
    }
}
```

The above code ensures to use a "json file based" maintenance mode driver, whenever the application is taken down.
For additional information, please review Laravel's documentation about maintenance modes.
