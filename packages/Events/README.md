# Athenaeum Events

The Athenaeum Events package offers way to register [Event Listeners](https://laravel.com/docs/6.x/events#registering-events-and-listeners) and [Subscribers](https://laravel.com/docs/6.x/events#event-subscribers) via configuration.

It serves as an alternative registration method than that provided by [Laravel](https://laravel.com).

## Example:

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

## Documentation

Please read the [official documentation](https://aedart.github.io/athenaeum/) for additional information.

## Repository

The mono repository is located at [github.com/aedart/athenaeum](https://github.com/aedart/athenaeum)

## Versioning

This package follows [Semantic Versioning 2.0.0](http://semver.org/)

## License

[BSD-3-Clause](http://spdx.org/licenses/BSD-3-Clause), Read the LICENSE file included in this package
