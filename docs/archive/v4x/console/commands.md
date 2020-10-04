---
description: How to register Commands
---
# Commands

To add new [commands](https://laravel.com/docs/7.x/artisan#writing-commands) to artisan, simply state the command's class paths inside your `configs/commands.php`

```php
<?php
return [
    \Acme\Console\GenerateSiteStatistics::class,
    \Acme\Console\SendWelcomeEmail::class,
    \Acme\Console\RemoveInactiveUsers::class,
    
    // ... etc
];
```
