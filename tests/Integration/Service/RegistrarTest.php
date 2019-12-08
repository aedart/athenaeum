<?php

namespace Aedart\Tests\Integration\Service;

use Aedart\Contracts\Service\Registrar as RegistrarInterface;
use Aedart\Service\Registrar;
use Aedart\Testing\TestCases\IntegrationTestCase;

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

    /**
     * Creates a new service provider registrar instance
     *
     * @return RegistrarInterface
     */
    protected function makeRegistrar() : RegistrarInterface
    {
        return new Registrar();
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

    // TODO: Remaining register and boot methods must be tested...
}
