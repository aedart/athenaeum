<?php

namespace Aedart\Tests\Integration\Circuits\Stores;

use Aedart\Circuits\Stores\CacheStore;
use Aedart\Contracts\Circuits\CircuitBreaker;
use Aedart\Contracts\Circuits\Exceptions\StateCannotBeLockedException;
use Aedart\Contracts\Circuits\Exceptions\UnknownStateException;
use Aedart\Contracts\Circuits\Store;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Circuits\CircuitBreakerTestCase;

/**
 * StoresTest
 *
 * @group circuits
 * @group circuits-stores
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Circuits\Stores
 */
class StoresTest extends CircuitBreakerTestCase
{
    /*****************************************************************
     * Data Providers
     ****************************************************************/

    /**
     * Provides stores
     *
     * @return array
     */
    public function providesStores()
    {
        return [
            'cache store' => [
                CacheStore::class,
                [ 'ttl' => 5, 'grace_period' => 5 ]
            ]
        ];
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     * @dataProvider providesStores
     *
     * @param string $driver
     * @param array $options
     */
    public function canObtainInstance(string $driver, array $options)
    {
        $store = $this->makeStoreWithService($driver, $options);

        $this->assertInstanceOf(Store::class, $store);
    }

    /**
     * @test
     * @dataProvider providesStores
     *
     * @param string $driver
     * @param array $options
     *
     * @throws UnknownStateException
     */
    public function canSetAndObtainState(string $driver, array $options)
    {
        $state = $this->makeState(CircuitBreaker::CLOSED);
        $store = $this->makeStoreWithService($driver, $options);

        $this->assertTrue($store->setState($state), 'State was not set');

        $obtainedState = $store->getState();
        ConsoleDebugger::output((string) $obtainedState);

        $this->assertSame($state->id(), $obtainedState->id(), 'Incorrect state retrieved');
    }

    /**
     * @test
     * @dataProvider providesStores
     *
     * @param string $driver
     * @param array $options
     */
    public function canRegisterFailure(string $driver, array $options)
    {
        $failure = $this->makeFailure($this->getFaker()->sentence);
        $store = $this->makeStoreWithService($driver, $options);

        $this->assertTrue($store->registerFailure($failure), 'Failure not registered');

        $lastFailure = $store->getFailure();
        ConsoleDebugger::output((string) $lastFailure);

        $this->assertSame($failure->reason(), $lastFailure->reason(), 'Incorrect last failure obtained');

        // Cleanup...
        $store->resetFailures();
    }

    /**
     * @test
     * @dataProvider providesStores
     *
     * @param string $driver
     * @param array $options
     */
    public function registersGracePeriodOnFailure(string $driver, array $options)
    {
        $store = $this->makeStoreWithService($driver, $options);

        // ------------------------------------------------ //
        // Default, grace period has past (none was registered)
        $this->assertTrue($store->hasGracePeriodPast(), 'A grace period should notexist');

        // ------------------------------------------------ //
        // When a failure is reported, time measurement should be
        // registered. Thus, a grace period exists and should not have
        // past.

        $failure = $this->makeFailure($this->getFaker()->sentence);
        $store->registerFailure($failure);

        $this->assertFalse($store->hasGracePeriodPast(), 'Grace period should not have past!');

        // Cleanup...
        $store->resetFailures();
    }

    /**
     * @test
     * @dataProvider providesStores
     *
     * @param string $driver
     * @param array $options
     */
    public function returnsNullWhenNoFailureRegistered(string $driver, array $options)
    {
        $store = $this->makeStoreWithService($driver, $options);

        $lastFailure = $store->getFailure();
        ConsoleDebugger::output((string) $lastFailure);

        $this->assertNull($lastFailure);
    }

    /**
     * @test
     * @dataProvider providesStores
     *
     * @param string $driver
     * @param array $options
     */
    public function increasesFailuresCountWhenFailureRegistered(string $driver, array $options)
    {
        $failureA = $this->makeFailure($this->getFaker()->sentence);
        $failureB = $this->makeFailure($this->getFaker()->sentence);
        $failureC = $this->makeFailure($this->getFaker()->sentence);

        $store = $this->makeStoreWithService($driver, $options);
        $store->registerFailure($failureA);
        $store->registerFailure($failureB);
        $store->registerFailure($failureC);

        $totalFailures = $store->totalFailures();
        ConsoleDebugger::output((string) $totalFailures);

        $this->assertSame(3, $totalFailures, 'Incorrect last failure obtained');

        // Cleanup...
        $store->resetFailures();
        $totalFailures = $store->totalFailures();
        ConsoleDebugger::output((string) $totalFailures);

        $this->assertSame(0, $totalFailures, 'Failures count not reset');
    }

    /**
     * @test
     * @dataProvider providesStores
     *
     * @param string $driver
     * @param array $options
     *
     * @throws UnknownStateException
     * @throws StateCannotBeLockedException
     */
    public function canLockState(string $driver, array $options)
    {
        $state = $this->makeState(CircuitBreaker::HALF_OPEN);
        $store = $this->makeStoreWithService($driver, $options);

        $lockObtained = false;
        $expected = $this->getFaker()->sentence;
        $callback = function () use (&$lockObtained, $expected) {
            $lockObtained = true;
            return $expected;
        };

        $result = $store->lockState($state, $callback);

        $this->assertSame($expected, $result, 'Incorrect result / lock not obtained');
        $this->assertTrue($lockObtained, 'Lock not obtained');
    }

    /**
     * @test
     * @dataProvider providesStores
     *
     * @param string $driver
     * @param array $options
     *
     * @throws UnknownStateException
     * @throws StateCannotBeLockedException
     */
    public function failsLockingIfStateIsNotLockable(string $driver, array $options)
    {
        $this->expectException(StateCannotBeLockedException::class);

        $state = $this->makeState(CircuitBreaker::CLOSED);
        $store = $this->makeStoreWithService($driver, $options);

        $store->lockState($state, fn () => '');
    }
}
