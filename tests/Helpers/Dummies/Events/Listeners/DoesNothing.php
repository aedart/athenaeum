<?php

namespace Aedart\Tests\Helpers\Dummies\Events\Listeners;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\Helpers\MessageBag;
use Aedart\Tests\Helpers\Dummies\Events\TestEvent;

/**
 * Does Nothing - Event Listener
 *
 * FOR TESTING PURPOSES ONLY
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Events\Listeners
 */
class DoesNothing
{
    /**
     * Handles the Test Event
     *
     * @param TestEvent $event
     */
    public function handle(TestEvent $event)
    {
        ConsoleDebugger::output(static::class . ' invoked');

        MessageBag::add(static::class . ' invoked');
    }
}
