<?php
return [

    /*
     |--------------------------------------------------------------------------
     | Events and Listeners
     |--------------------------------------------------------------------------
     |
     | List of events and their associated event listeners.
    */

    'listeners' => [

        \Aedart\Tests\Helpers\Dummies\Events\TestEvent::class => [
            \Aedart\Tests\Helpers\Dummies\Events\Listeners\DoesNothing::class
        ]

    ],

    /*
     |--------------------------------------------------------------------------
     | Subscribers
     |--------------------------------------------------------------------------
     |
     | List of event subscribers
    */

    'subscribers' => [

        \Aedart\Tests\Helpers\Dummies\Events\Subscribers\FooEventSubscriber::class

    ]
];
