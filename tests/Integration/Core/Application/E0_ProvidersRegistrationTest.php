<?php

namespace Aedart\Tests\Integration\Core\Application;

use Aedart\Core\Bootstrappers\DetectAndLoadEnvironment;
use Aedart\Core\Bootstrappers\LoadConfiguration;
use Aedart\Core\Bootstrappers\RegisterApplicationServiceProviders;
use Aedart\Core\Bootstrappers\SetDefaultTimezone;
use Aedart\Tests\Helpers\Dummies\Service\Providers\Nested\ServiceProviderC1;
use Aedart\Tests\Helpers\Dummies\Service\Providers\Nested\ServiceProviderC2;
use Aedart\Tests\Helpers\Dummies\Service\Providers\Nested\ServiceProviderC3;
use Aedart\Tests\Helpers\Dummies\Service\Providers\ServiceProviderA;
use Aedart\Tests\Helpers\Dummies\Service\Providers\ServiceProviderB;
use Aedart\Tests\Helpers\Dummies\Service\Providers\ServiceProviderC;
use Aedart\Tests\Helpers\Dummies\Service\Providers\ServiceProviderD;
use Aedart\Tests\TestCases\AthenaeumAppTestCase;

/**
 * E0_ProvidersRegistrationTest
 *
 * @group application
 * @group application-e0
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Core\Application
 */
class E0_ProvidersRegistrationTest extends AthenaeumAppTestCase
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

    /**
     * @test
     */
    public function registersAppServiceProviders()
    {
        $this->bootstrap();

        $registrar = $this->app->getServiceProviderRegistrar();
        $expected = [
            ServiceProviderA::class,
            ServiceProviderB::class,

            ServiceProviderC::class,
            ServiceProviderC1::class,
            ServiceProviderC2::class,
            ServiceProviderC3::class,

            ServiceProviderD::class,
        ];

        foreach ($expected as $provider){
            $this->assertTrue($registrar->isRegistered($provider), $provider . ' is not registered');
        }
    }
}
