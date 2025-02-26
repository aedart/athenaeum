---
description: Task Scheduling in Core Application
---

# Task Scheduling

Laravel's [Tasks Scheduling](https://laravel.com/docs/11.x/scheduling) is also offered by the [Console Application](./console).

## Define Tasks

The [Console Package](../../console/schedules.md) contains examples of how to define scheduled tasks and how to register them.

## Run Scheduled Tasks

Just like Laravel, you need to add the `schedule:run` command to your [Cron](https://en.wikipedia.org/wiki/Cron).
Review Laravel's [documentation](https://laravel.com/docs/11.x/scheduling) for more information about how to run scheduled tasks

```
* * * * * cd /your-project-path && php cli.php schedule:run >> /dev/null 2>&1
```

### Run Scheduled Tasks in Windows

It is possible to use [Windows Tasks Scheduler](https://en.wikipedia.org/wiki/Windows_Task_Scheduler), in order to utilise Laravel's scheduled tasks.
Waleed Ahmed wrote a nice article about [how to use Task Scheduler on Windows 10](https://quantizd.com/how-to-use-laravel-task-scheduler-on-windows-10/).

## Limitations

[Scheduled Queued Jobs](https://laravel.com/docs/11.x/scheduling#scheduling-queued-jobs) are not support by default.
You have to add Laravel's [Queue package](https://packagist.org/packages/illuminate/queue) by on your own, in order to gain access to this feature. 
