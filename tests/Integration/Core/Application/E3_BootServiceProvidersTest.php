<?php

namespace Aedart\Tests\Integration\Core\Application;

use Aedart\Core\Bootstrappers\DetectAndLoadEnvironment;
use Aedart\Core\Bootstrappers\LoadConfiguration;
use Aedart\Core\Bootstrappers\RegisterApplicationServiceProviders;
use Aedart\Tests\Helpers\Dummies\Service\Providers\Nested\ServiceProviderC1;
use Aedart\Tests\Helpers\Dummies\Service\Providers\Nested\ServiceProviderC2;
use Aedart\Tests\Helpers\Dummies\Service\Providers\Nested\ServiceProviderC3;
use Aedart\Tests\Helpers\Dummies\Service\Providers\ServiceProviderA;
use Aedart\Tests\Helpers\Dummies\Service\Providers\ServiceProviderB;
use Aedart\Tests\Helpers\Dummies\Service\Providers\ServiceProviderC;
use Aedart\Tests\Helpers\Dummies\Service\Providers\ServiceProviderD;
use Aedart\Tests\TestCases\AthenaeumCoreTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * E2_BootServiceProvidersTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Core\Application
 */
#[Group(
    'application',
    'application-e3',
)]
class E3_BootServiceProvidersTest extends AthenaeumCoreTestCase
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

    /**
     * Bootstrap and boot the application
     */
    protected function boot()
    {
        $this->bootstrap();

        $this->app->boot();
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    #[Test]
    public function bootsServiceProviders()
    {
        $this->boot();

        $providers = $this->app->getServiceProviderRegistrar()->booted();
        $expected = [
            ServiceProviderA::class,
            ServiceProviderB::class,

            ServiceProviderC::class,
            ServiceProviderC1::class,
            ServiceProviderC2::class,
            ServiceProviderC3::class,

            ServiceProviderD::class,
        ];

        $this->assertTrue($this->app->isBooted(), 'Application has not booted');

        // Note: We do not need to test more than this, because of the
        // separate service registrar tests,...
        // @see \Aedart\Tests\Integration\Service\RegistrarTest
        $this->assertGreaterThanOrEqual(count($expected), count($providers), 'Incorrect amount of services booted');
    }

    #[Test]
    public function invokesBeforeAndAfterBootCallbacks()
    {
        // States
        $hasInvokedBefore = false;
        $hasInvokedAfter = false;

        // Define callbacks
        $before = function () use (&$hasInvokedBefore) {
            $hasInvokedBefore = true;
        };
        $after = function () use (&$hasInvokedAfter) {
            $hasInvokedAfter = true;
        };

        // Set callbacks
        $this->app->booting($before);
        $this->app->booted($after);

        // Boot...
        $this->boot();

        // Check if callbacks invoked
        $this->assertTrue($hasInvokedBefore, 'before callback not invoked');
        $this->assertTrue($hasInvokedAfter, 'after callback not invoked');
    }

    #[Test]
    public function invokesAfterCallbackIfAlreadyBooted()
    {
        // States
        $hasInvokedAfter = false;

        // Define callbacks
        $after = function () use (&$hasInvokedAfter) {
            $hasInvokedAfter = true;
        };

        // Boot...
        $this->boot();

        // Set callbacks after invoke
        $this->app->booted($after);

        // Check if callbacks invoked
        $this->assertTrue($hasInvokedAfter, 'after callback not invoked');
    }
}
