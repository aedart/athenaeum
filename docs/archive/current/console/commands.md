---
description: How to register Commands
---
# Commands

To add new [commands](https://laravel.com/docs/6.x/artisan#writing-commands) to artisan, simply state the command's class path inside your `configs/commands.php`

```php
<?php
return [
    \Acme\Console\GenerateSiteStatistics::class,
    
    // ... etc
];
```
