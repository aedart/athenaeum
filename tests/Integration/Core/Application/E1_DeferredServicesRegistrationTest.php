<?php

namespace Aedart\Tests\Integration\Core\Application;

use Aedart\Core\Bootstrappers\DetectAndLoadEnvironment;
use Aedart\Core\Bootstrappers\LoadConfiguration;
use Aedart\Core\Bootstrappers\RegisterApplicationServiceProviders;
use Aedart\Tests\Helpers\Dummies\Contracts\Box;
use Aedart\Tests\Helpers\Dummies\Events\TestEvent;
use Aedart\Tests\Helpers\Dummies\Service\Providers\DeferredServiceProvider;
use Aedart\Tests\TestCases\AthenaeumCoreTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * E1_DeferredServicesRegistrationTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Core\Application
 */
#[Group(
    'application',
    'application-e1',
)]
class E1_DeferredServicesRegistrationTest extends AthenaeumCoreTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Bootstrap the application
     */
    protected function bootstrap()
    {
        $this->app->bootstrapWith([
            DetectAndLoadEnvironment::class,
            LoadConfiguration::class,
            RegisterApplicationServiceProviders::class
        ]);
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    #[Test]
    public function canRegisterDeferredServices()
    {
        $this->bootstrap();

        $this->assertTrue($this->app->isDeferredService(Box::class), 'Component should be registered as a deferred service');
    }

    #[Test]
    public function canResolveDeferredService()
    {
        $this->bootstrap();

        // Is bound check
        $this->assertTrue($this->app->bound(Box::class), 'Component should be bound');

        // Instance check
        $instance = $this->app->make(Box::class);
        $this->assertInstanceOf(Box::class, $instance, 'Invalid deferred service resolved');

        // Service should no longer be marked as deferred now...
        $this->assertFalse($this->app->isDeferredService(Box::class), 'Component should no longer be deferred');
    }

    #[Test]
    public function triggersRegistrationViaEvent()
    {
        $this->bootstrap();

        $dispatcher = $this->app->getDispatcher();

        // Check if event listener has been registered
        $this->assertTrue($dispatcher->hasListeners(TestEvent::class), 'Event should had been registered');

        // The "Deferred Service" defines an event that should trigger registration
        // automatically. Thus we attempt to dispatch that event
        $dispatcher->dispatch(new TestEvent());

        // Check if service has been registered
        $hasRegistered = $this->app->getServiceProviderRegistrar()->isRegistered(DeferredServiceProvider::class);
        $this->assertTrue($hasRegistered, 'Service has not registered');

        // Ensure that the given event listener no longer is present
        $this->assertFalse($dispatcher->hasListeners(TestEvent::class), 'Event should no longer present');
    }
}
