<?php

namespace Aedart\Tests\Integration\Service;

use Aedart\Contracts\Service\Registrar as RegistrarInterface;
use Aedart\Service\Registrar;
use Aedart\Testing\Helpers\MessageBag;
use Aedart\Testing\TestCases\IntegrationTestCase;
use Aedart\Tests\Helpers\Dummies\Service\Providers\Partials\ProviderState;
use Aedart\Tests\Helpers\Dummies\Service\Providers\ServiceProviderA;
use Aedart\Tests\Helpers\Dummies\Service\Providers\ServiceProviderB;
use Aedart\Tests\Helpers\Dummies\Service\Providers\ServiceProviderD;
use Illuminate\Support\ServiceProvider;

/**
 * RegistrarTest
 *
 * @group service
 * @group service-registrar
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Service
 */
class RegistrarTest extends IntegrationTestCase
{
    protected function _after()
    {
        // Clear cached messages
        MessageBag::clearAll();

        parent::_after();
    }

    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Creates a new service provider registrar instance
     *
     * @return RegistrarInterface
     */
    protected function makeRegistrar() : RegistrarInterface
    {
        return new Registrar();
    }

    /**
     * Returns a list of service providers
     *
     * @return string[]|ServiceProvider[]
     */
    protected function simpleProvidersList() : array
    {
        return [
            ServiceProviderA::class,
            ServiceProviderB::class,
            new ServiceProviderD($this->ioc)
        ];
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     */
    public function canCreateInstance()
    {
        $registrar = $this->makeRegistrar();
        $this->assertNotNull($registrar);
    }

    /**
     * @test
     */
    public function canRegisterMultipleServiceProviders()
    {
        $registrar = $this->makeRegistrar();
        $providers = $this->simpleProvidersList();
        $registrar->registerMultiple($providers, false);

        $registeredProviders = $registrar->providers();
        $bootedProviders = $registrar->booted();

        // ----------------------------------------------------- //

        $this->assertCount(count($providers), $registeredProviders, 'Incorrect amount of providers registered');
        $this->assertCount(0, $bootedProviders, 'Should NOT have booted any providers');

        foreach ($registeredProviders as $provider){
            /** @var ProviderState $provider */
            $this->assertTrue($provider->hasRegistered, sprintf('%s has not been marked as registered', get_class($provider)));
        }
    }

    /**
     * @test
     */
    public function canRegisterAndBootMultipleServiceProviders()
    {
        $registrar = $this->makeRegistrar();
        $providers = $this->simpleProvidersList();
        $registrar->registerMultiple($providers);

        $registeredProviders = $registrar->providers();
        $bootedProviders = $registrar->booted();

        // ----------------------------------------------------- //

        $this->assertCount(count($providers), $registeredProviders, 'Incorrect amount of providers registered');
        $this->assertCount(count($providers), $bootedProviders, 'Incorrect amount of providers registered');

        foreach ($registeredProviders as $provider){
            /** @var ProviderState $provider */
            $this->assertTrue($provider->hasRegistered, sprintf('%s has not been marked as registered', get_class($provider)));
            $this->assertTrue($provider->hasBooted, sprintf('%s has not been marked as booted', get_class($provider)));
        }
    }

    /**
     * @test
     */
    public function canRegisterAndBootUnsafe()
    {
        $registrar = $this->makeRegistrar();
        $providers = $this->simpleProvidersList();
        $registrar->registerMultiple($providers, true, false);

        // ----------------------------------------------------- //
        $messages = MessageBag::all();

        // Verify that register & boot order is correct
        $this->assertStringContainsString('A has registered', $messages[0]);
        $this->assertStringContainsString('A has booted', $messages[1]);
        $this->assertStringContainsString('B has registered', $messages[2]);
        $this->assertStringContainsString('B has booted', $messages[3]);
        $this->assertStringContainsString('D has registered', $messages[4]);
        $this->assertStringContainsString('D has booted', $messages[5]);
    }

    /**
     * @test
     */
    public function doesNotRegisterSameProviderTwice()
    {
        $registrar = $this->makeRegistrar();
        $providers = [
            ServiceProviderA::class,
            ServiceProviderA::class,
        ];
        $registrar->registerMultiple($providers);

        $registeredProviders = $registrar->providers();

        // ----------------------------------------------------- //
        $this->assertCount(1, $registeredProviders, 'Should NOT allow multiple registration of same provider');
    }

    /**
     * @test
     */
    public function doesNotBootSameProviderTwice()
    {
        $registrar = $this->makeRegistrar();
        $providers = [
            ServiceProviderA::class,
        ];
        $registrar->registerMultiple($providers);

        $registeredProviders = $registrar->providers();
        $serviceProviderA = array_shift($registeredProviders);

        $result = $registrar->boot($serviceProviderA);

        $bootedProviders = $registrar->booted();

        // ----------------------------------------------------- //
        $this->assertFalse($result, 'Should NOT have booted already booted service provider');
        $this->assertCount(1, $bootedProviders, 'Should NOT allow multiple booting of same provider');
    }
}
