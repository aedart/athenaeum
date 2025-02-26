---
description: How to register Schedules
---
# Schedules

## Define Schedules

First, you need to create a component that inherits from `SchedulesTasks`.
It is responsible for the actual scheduled task / event definition.

```php
<?php

namespace Acme\Schedules;

use Aedart\Contracts\Console\Scheduling\SchedulesTasks;
use Acme\Console\DeactivateInactiveUsers;
use Acme\Console\SendNewsHighlights;

class DefinesUserTasks implements SchedulesTasks
{
    public function schedule($schedule): void
    {
        $schedule
            ->command(DeactivateInactiveUsers::class)
            ->monthly();

        $schedule
            ->command(SendNewsHighlights::class)
            ->weekly()
            ->sundays();
    }
}
```

## Register Schedules

Once you have completed your schedules, state the component's class path inside `config/schedule.php`.

```php
<?php
return [
    'tasks' => [
        Acme\Schedules\DefinesUserTasks::class,
        
        // ... etc

    ]
];
```

## Onward

You can read more about Task Scheduling in [Laravel's Documentation](https://laravel.com/docs/11.x/scheduling).
