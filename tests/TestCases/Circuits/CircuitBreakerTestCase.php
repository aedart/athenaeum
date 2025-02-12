<?php

namespace Aedart\Tests\TestCases\Circuits;

use Aedart\Circuits\Providers\CircuitBreakerServiceProvider;
use Aedart\Circuits\Traits\CircuitBreakerManagerTrait;
use Aedart\Circuits\Traits\FailureFactoryTrait;
use Aedart\Circuits\Traits\StateFactoryTrait;
use Aedart\Config\Providers\ConfigLoaderServiceProvider;
use Aedart\Config\Traits\ConfigLoaderTrait;
use Aedart\Contracts\Circuits\CircuitBreaker;
use Aedart\Contracts\Circuits\Exceptions\ProfileNotFoundException;
use Aedart\Contracts\Circuits\Exceptions\UnknownStateException;
use Aedart\Contracts\Circuits\Failure;
use Aedart\Contracts\Circuits\State;
use Aedart\Contracts\Circuits\Store;
use Aedart\Testing\TestCases\LaravelTestCase;
use Codeception\Configuration;
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
    use ConfigLoaderTrait;
    use CircuitBreakerManagerTrait;
    use StateFactoryTrait;
    use FailureFactoryTrait;

    /*****************************************************************
     * Setup
     ****************************************************************/

    /**
     * @inheritDoc
     */
    protected function _before()
    {
        parent::_before();

        $this->getConfigLoader()
            ->setDirectory($this->configDir())
            ->load();
    }

    /**
     * {@inheritdoc}
     */
    protected function getPackageProviders($app)
    {
        return [
            ConfigLoaderServiceProvider::class,
            CircuitBreakerServiceProvider::class
        ];
    }

    /*****************************************************************
     * Paths
     ****************************************************************/

    /**
     * Returns path to configuration directory
     *
     * @return string
     */
    public function configDir(): string
    {
        return Configuration::dataDir() . 'configs/circuits/';
    }

    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Creates a new circuit breaker instance
     *
     * @param string $service Name of service (profile name)
     * @param array $options [optional]
     * @param bool $reset [optional] If true, last failure, amount failures, and state is
     *                               reset.
     *
     * @return CircuitBreaker
     *
     * @throws ProfileNotFoundException
     */
    protected function makeCircuitBreaker(string $service, array $options = [], bool $reset = true): CircuitBreaker
    {
        $circuitBreaker = $this->getCircuitBreakerManager()->create($service, $options);

        // Reset state, failures, etc., to avoid unintended side effects per test
        if ($reset) {
            $circuitBreaker->store()->reset();
            $circuitBreaker->changeState(
                $this->makeState(CircuitBreaker::CLOSED)
            );
        }

        return $circuitBreaker;
    }

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
    protected function makeStoreWithService(string|null $driver = null, array $options = []): Store
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
    protected function makeStore(string|null $service, string $driver = null, array $options = []): Store
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
        int|null $previous = null,
        string|DateTimeInterface|null $createdAt = null,
        string|DateTimeInterface|null $expiresAt = null
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
        string|null $reason = null,
        array $context = [],
        string|DateTimeInterface|null $reportedAt = null,
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
