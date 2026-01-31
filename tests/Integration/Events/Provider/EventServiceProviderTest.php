<?php

namespace Aedart\Tests\Integration\Events\Provider;

use Aedart\Testing\Helpers\MessageBag;
use Aedart\Tests\Helpers\Dummies\Events\FooEvent;
use Aedart\Tests\Helpers\Dummies\Events\Listeners\DoesNothing;
use Aedart\Tests\Helpers\Dummies\Events\Subscribers\FooEventSubscriber;
use Aedart\Tests\Helpers\Dummies\Events\TestEvent;
use Aedart\Tests\TestCases\AthenaeumCoreTestCase;
use Codeception\Attribute\Group;
use Codeception\Configuration;
use PHPUnit\Framework\Attributes\Test;

/**
 * EventServiceProviderTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Events\Provider
 */
#[Group(
    'application',
    'events',
)]
class EventServiceProviderTest extends AthenaeumCoreTestCase
{
    /**
     * @inheritdoc
     */
    protected function _after()
    {
        MessageBag::clearAll();

        parent::_after();
    }

    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * @inheritdoc
     */
    protected function applicationPaths(): array
    {
        return array_merge(parent::applicationPaths(), [
            'configPath' => Configuration::dataDir() . 'configs' . DIRECTORY_SEPARATOR . 'events'
        ]);
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @throws \Throwable
     */
    #[Test]
    public function hasLoadedEventsConfiguration()
    {
        $this->app->run();

        $hasLoaded = $this->app->getConfig()->has('events');
        $this->assertTrue($hasLoaded);
    }

    /**
     * @throws \Throwable
     */
    #[Test]
    public function hasRegisteredListeners()
    {
        $this->app->run();

        // We test this directly by dispatching the test event
        $this->app->getDispatcher()->dispatch(new TestEvent());

        $messages = MessageBag::all();
        $this->assertStringContainsString(DoesNothing::class . ' invoked', array_shift($messages));
    }

    /**
     * @throws \Throwable
     */
    #[Test]
    public function hasRegisteredSubscribers()
    {
        $this->app->run();

        // The same as previous test, we verify by dispatching an event
        $this->app->getDispatcher()->dispatch(new FooEvent());

        $messages = MessageBag::all();
        $this->assertStringContainsString(FooEventSubscriber::class . ' invoked', array_shift($messages));
    }
}
