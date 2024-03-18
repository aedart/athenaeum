---
description: Registration of Subscribers
---

# Subscribers

To register event [Subscribers](https://laravel.com/docs/10.x/events#event-subscribers), state the class path of your subscribers inside the `subscribers` key, in your `/config/events.php` file.

```php
<?php
return [

    // ... previous not shown ...
    'subscribers' => [

        \Acme\Imports\Subscribers\ImportEventSubscriber::class,
        \Acme\Users\Subscribers\UserEventSubscriber::class,
        \Acme\Api\Subscribers\ApiEventSubscriber::class,

        // ... etc
    ]
];
```
