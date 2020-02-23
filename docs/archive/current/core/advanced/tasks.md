---
description: Task Scheduling in Core Application
---

# Task Scheduling

The [Console Package](../../console/schedules.md) contains examples of how to define scheduled tasks and how to register them.

## Run Scheduled Tasks

Just like Laravel, you need to add the `schedule:run` command to your [Cron](https://en.wikipedia.org/wiki/Cron).
Review Laravel's [documentation](https://laravel.com/docs/6.x/scheduling) for more information about how to run scheduled tasks

```
* * * * * cd /path-to-your-project && php cli.php schedule:run >> /dev/null 2>&1
```