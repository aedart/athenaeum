<?php

namespace Aedart\Tests\Helpers\Dummies\Events\Subscribers;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\Helpers\MessageBag;
use Aedart\Tests\Helpers\Dummies\Events\FooEvent;
use Aedart\Tests\Helpers\Dummies\Events\Listeners\DoesNothing;
use Aedart\Tests\Helpers\Dummies\Events\TestEvent;
use Illuminate\Contracts\Events\Dispatcher;

/**
 * Foo Event Subscriber
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Events\Subscribers
 */
class FooEventSubscriber
{
    /**
     * Subscribes to one or more events
     *
     * @param Dispatcher $dispatcher
     */
    public function subscribe(Dispatcher $dispatcher)
    {
        $dispatcher->listen(
            FooEvent::class,
            static::class . '@handleFoo'
        );
    }

    /**
     * Handles Foo event
     *
     * @param FooEvent $event
     */
    public function handleFoo(FooEvent $event)
    {
        ConsoleDebugger::output(static::class . ' invoked');

        MessageBag::add(static::class . ' invoked');
    }
}
