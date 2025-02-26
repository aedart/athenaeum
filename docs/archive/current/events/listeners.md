---
description: Registration of Event Listeners
---

# Listeners

To register event listeners, state the [Event](https://laravel.com/docs/12.x/events#defining-events) class path or identifier inside the `listeners` key, in your `/config/events.php` file.
Then, state the class paths of your event listeners for the given event.

```php
<?php
return [

    'listeners' => [
    
        // Class path for event
        \Acme\Imports\Events\ProductsImportent::class => [
        
            // Event listeners
            \Acme\Imports\Listeners\NotifyStaffAboutNewProducts::class,
            \Acme\Imports\Listeners\MarkImportFileAsDone::class,
        ],
    
        // Event identifier, e.g. a wildcard event listener
        '\Acme\Imports\Events\*' => [
            \Acma\Imports\Listeners\LogImportAction::class
        ],
    ],
    
    // ... remaining not shown ...
];
```
