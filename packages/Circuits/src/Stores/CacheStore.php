<?php

namespace Aedart\Circuits\Stores;

use Aedart\Circuits\Exceptions\StateCannotBeLocked;
use Aedart\Circuits\Exceptions\StoreException;
use Aedart\Contracts\Circuits\CircuitBreaker;
use Aedart\Contracts\Circuits\Failure;
use Aedart\Contracts\Circuits\State;
use Aedart\Contracts\Circuits\States\Lockable;
use Aedart\Contracts\Circuits\Store;
use Aedart\Contracts\Support\Helpers\Cache\CacheAware;
use Aedart\Contracts\Support\Helpers\Cache\CacheFactoryAware;
use Aedart\Support\Helpers\Cache\CacheFactoryTrait;
use Aedart\Support\Helpers\Cache\CacheTrait;
use Illuminate\Contracts\Cache\LockProvider;
use Illuminate\Contracts\Cache\Repository;

/**
 * Cache Store
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Circuits\Stores
 */
class CacheStore extends BaseStore implements
    CacheFactoryAware,
    CacheAware
{
    use CacheFactoryTrait;
    use CacheTrait {
        setCache as traitSetCache;
    }

    /**
     * State key
     *
     * @var string
     */
    protected string $stateKey;

    /**
     * Locked state key
     *
     * @var string
     */
    protected string $lockedStateKey;

    /**
     * Total failures key
     *
     * @var string
     */
    protected string $totalFailuresKey;

    /**
     * Grace period key
     *
     * @var string
     */
    protected string $gracePeriodKey;

    /**
     * Last detected (or reported) failure key
     *
     * @var string
     */
    protected string $lastFailureKey;

    /**
     * CacheStore constructor.
     *
     * @param string $service
     * @param array $options [optional]
     */
    public function __construct(string $service, array $options = [])
    {
        parent::__construct($service, $options);

        $this
            ->prepareKeys();
    }

    /**
     * @inheritDoc
     */
    public function setState(State $state): bool
    {
        $wasChanged = $this->getCache()->put(
            $this->stateKey,
            $this->toStore($state),
            $this->stateTtl($state)
        );

        if ($wasChanged) {
            $this->dispatchStateChange($state);
        }

        return $wasChanged;
    }

    /**
     * @inheritDoc
     */
    public function getState(): State
    {
        $state = $this->getCache()->get($this->stateKey);

        if (!isset($state)) {
            return $this->getStateFactory()->make(CircuitBreaker::CLOSED);
        }

        return $this->fromStore($state);
    }

    /**
     * @inheritDoc
     */
    public function lockState(State $state, callable $callback)
    {
        if (!($state instanceof Lockable)) {
            throw new StateCannotBeLocked(sprintf('%s state cannot be locked', $state->name()));
        }

        /** @var \Illuminate\Contracts\Cache\Store|LockProvider $store */
        $store = $this->getCache()->getStore();
        $lock = $store->lock(
            $this->lockedStateKey,
            $this->stateTtl($state),
            $this->service
        );

        // Attempt acquire lock. If successfully, then the callback is invoked and
        // released. If not, then "false" is returned.
        return $lock->get(function () use ($state, $callback) {
            $this->dispatchStateChange($state);

            return $callback();
        });
    }

    /**
     * @inheritDoc
     */
    public function registerFailure(Failure $failure): bool
    {
        $persisted = $this->getCache()->forever(
            $this->lastFailureKey,
            $this->toStore($failure)
        );

        if ($persisted) {
            $this->incrementFailures();
            $this->dispatchFailureReported($failure);
        }

        return $persisted;
    }

    /**
     * @inheritDoc
     */
    public function getFailure(): ?Failure
    {
        $failure = $this->getCache()->get($this->lastFailureKey);

        if (!isset($failure)) {
            return null;
        }

        return $this->fromStore($failure);
    }

    /**
     * @inheritDoc
     */
    public function incrementFailures(int $amount = 1): int
    {
        $total = $this->getCache()->increment($this->totalFailuresKey, $amount);

        if ($total === false) {
            throw new StoreException('Unable to increment total amount of failures');
        }

        return $total;
    }

    /**
     * @inheritDoc
     */
    public function totalFailures(): int
    {
        return $this->getCache()->get($this->totalFailuresKey, 0);
    }

    /**
     * @inheritDoc
     */
    public function startGracePeriod(int $duration = 10): Store
    {
        // Add a grace period ONLY if one does not already exist.
        $this->getCache()->add(
            $this->gracePeriodKey,
            false,
            $duration
        );

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function hasGracePeriodPast(): bool
    {
        return $this->getCache()->get($this->gracePeriodKey, true);
    }

    /**
     * @inheritDoc
     */
    public function reset(): Store
    {
        $this->getCache()->deleteMultiple([
            $this->gracePeriodKey,
            $this->totalFailuresKey,
            $this->lastFailureKey
        ]);

        return $this;
    }

    /*****************************************************************
     * Defaults
     ****************************************************************/

    /**
     * @inheritDoc
     */
    public function setCache(?Repository $repository)
    {
        if (!($repository->getStore() instanceof LockProvider)) {
            throw new StoreException('Only "Lock Provider" cache-stores can be used by Circuit Breaker Cache Store');
        }

        return $this->traitSetCache($repository);
    }

    /**
     * @inheritDoc
     */
    public function getDefaultCache(): ?Repository
    {
        return $this->getCacheFactory()->store(
            $this->getOption('cache-store')
        );
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Prepares keys - cache item identifiers
     *
     * @return self
     */
    protected function prepareKeys()
    {
        $this->stateKey = $this->key('state');
        $this->lockedStateKey = $this->key('locked');
        $this->totalFailuresKey = $this->key('total_failures');
        $this->lastFailureKey = $this->key('last_failure');
        $this->gracePeriodKey = $this->key('grace_period');

        return $this;
    }
}
