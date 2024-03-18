---
description: About the Events Package
---

# Register Listeners and Subscribers

The Athenaeum Events package offers way to register [Event Listeners](https://laravel.com/docs/10.x/events#registering-events-and-listeners) and [Subscribers](https://laravel.com/docs/10.x/events#event-subscribers) via configuration.

It serves as an alternative registration method than that provided by [Laravel](https://laravel.com).

```php
<?php
return [

    'listeners' => [

        \Acme\Users\Events\UserCreated::class => [
            \Acme\Users\Listeners\LogNewUser::class,
            \Acme\Users\Listeners\SendWelcomeEmail::class,
        ],
        'payments.*' => [
            \Acma\Payments\Listeners\VerifyPaymentSession::class
        ],
        
        // ... etc
    ],

    'subscribers' => [

        \Acme\Orders\Subscribers\OrderEventsSubscriber::class,
        \Acme\Users\Subscribers\TrialPeriodSubscriber::class,

        // ... etc
    ]
];
```
