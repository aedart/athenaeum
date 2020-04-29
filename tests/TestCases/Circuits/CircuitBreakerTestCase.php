<?php

namespace Aedart\Tests\TestCases\Circuits;

use Aedart\Circuits\Providers\CircuitBreakerServiceProvider;
use Aedart\Circuits\Traits\CircuitBreakerManagerTrait;
use Aedart\Circuits\Traits\FailureFactoryTrait;
use Aedart\Circuits\Traits\StateFactoryTrait;
use Aedart\Contracts\Circuits\Exceptions\UnknownStateException;
use Aedart\Contracts\Circuits\Failure;
use Aedart\Contracts\Circuits\State;
use Aedart\Contracts\Circuits\Store;
use Aedart\Testing\TestCases\LaravelTestCase;
use DateTimeInterface;
use Illuminate\Support\Facades\Date;

/**
 * CircuitsTestCase
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\TestCases\Circuits
 */
abstract class CircuitBreakerTestCase extends LaravelTestCase
{
    use CircuitBreakerManagerTrait;
    use StateFactoryTrait;
    use FailureFactoryTrait;

    /*****************************************************************
     * Setup
     ****************************************************************/

    /**
     * {@inheritdoc}
     */
    protected function getPackageProviders($app)
    {
        return [
            CircuitBreakerServiceProvider::class
        ];
    }

    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Creates a new circuit breaker store instance, with a random generated
     * service name
     *
     * @see makeStore
     *
     * @param string|null $driver [optional]
     * @param array $options [optional]
     *
     * @return Store
     */
    protected function makeStoreWithService(string $driver = null, array $options = []): Store
    {
        $service = $this->getFaker()->unique()->words(3, true);

        return $this->makeStore($service, $driver, $options);
    }

    /**
     * Creates a new circuit breaker store instance
     *
     * @param string|null $service
     * @param string|null $driver [optional]
     * @param array $options [optional]
     *
     * @return Store
     */
    protected function makeStore(string $service, string $driver = null, array $options = []): Store
    {
        return $this->getCircuitBreakerManager()->store($service, $driver, $options);
    }

    /**
     * Creates a new state instance
     *
     * @param int $id
     * @param int|null $previous [optional]
     * @param string|DateTimeInterface|null $createdAt [optional]
     * @param string|DateTimeInterface|null $expiresAt [optional]
     *
     * @return State
     *
     * @throws UnknownStateException
     */
    protected function makeState(
        int $id,
        ?int $previous = null,
        $createdAt = null,
        $expiresAt = null
    ): State {
        $createdAt = $createdAt ?? Date::now();

        return $this->getStateFactory()->make(
            $id,
            $previous,
            $createdAt,
            $expiresAt
        );
    }

    /**
     * Creates a new failure instance
     *
     * @param string|null $reason [optional]
     * @param array $context [optional]
     * @param string|DateTimeInterface|null $reportedAt [optional]
     * @param int $totalFailures [optional]
     *
     * @return Failure
     */
    public function makeFailure(
        ?string $reason = null,
        array $context = [],
        $reportedAt = null,
        int $totalFailures = 0
    ): Failure {
        $reportedAt = $reportedAt ?? Date::now();

        return $this->getFailureFactory()->make(
            $reason,
            $context,
            $reportedAt,
            $totalFailures
        );
    }
}
