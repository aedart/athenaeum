<?php

namespace Aedart\Tests\Integration\Circuits;

use Aedart\Contracts\Circuits\CircuitBreaker;
use Aedart\Contracts\Circuits\Exceptions\ProfileNotFoundException;
use Aedart\Tests\TestCases\Circuits\CircuitBreakerTestCase;

/**
 * ManagerTest
 *
 * @group circuits
 * @group circuit-breaker
 * @group circuit-breaker-manager
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Circuits
 */
class ManagerTest extends CircuitBreakerTestCase
{
    /**
     * @test
     *
     * @throws ProfileNotFoundException
     */
    public function canCreateCircuitBreaker()
    {
        $circuitBreaker = $this->makeCircuitBreaker('my_service');

        $this->assertInstanceOf(CircuitBreaker::class, $circuitBreaker);
    }

    /**
     * @test
     *
     * @throws ProfileNotFoundException
     */
    public function returnsSameCircuitBreaker()
    {
        $circuitBreakerA = $this->makeCircuitBreaker('my_service');
        $circuitBreakerB = $this->makeCircuitBreaker('my_service');

        $this->assertSame($circuitBreakerA, $circuitBreakerB);
    }

    /**
     * @test
     *
     * @throws ProfileNotFoundException
     */
    public function failsWhenServiceDoesNotExist()
    {
        $this->expectException(ProfileNotFoundException::class);

        $this->makeCircuitBreaker('my_unknown_service');
    }

    /**
     * @test
     *
     * @throws ProfileNotFoundException
     */
    public function failsWhenStoreProfileDoesNotExist()
    {
        $this->expectException(ProfileNotFoundException::class);

        $this->makeCircuitBreaker('my_service', [
            'store' => 'my_unknown_store'
        ]);
    }
}
