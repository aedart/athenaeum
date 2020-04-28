<?php

namespace Aedart\Circuits\Stores;

use Aedart\Circuits\Exceptions\StateCannotBeLocked;
use Aedart\Circuits\Exceptions\StoreException;
use Aedart\Circuits\Stores\Options\CacheStoreOptions;
use Aedart\Contracts\Circuits\CircuitBreaker;
use Aedart\Contracts\Circuits\Failure;
use Aedart\Contracts\Circuits\State;
use Aedart\Contracts\Circuits\States\Lockable;
use Aedart\Contracts\Circuits\Store;
use Aedart\Contracts\Support\Helpers\Cache\CacheFactoryAware;
use Aedart\Contracts\Support\Helpers\Cache\CacheStoreAware;
use Aedart\Support\Helpers\Cache\CacheFactoryTrait;
use Aedart\Support\Helpers\Cache\CacheStoreTrait;
use Illuminate\Contracts\Cache\LockProvider;
use Illuminate\Contracts\Cache\Store as LaravelCacheStore;

/**
 * Cache Store
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Circuits\Stores
 */
class CacheStore extends BaseStore implements
    CacheFactoryAware,
    CacheStoreAware
{
    use CacheFactoryTrait;
    use CacheStoreTrait;

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
     * Last detected (or reported) failure key
     *
     * @var string
     */
    protected string $lastFailureKey;

    /**
     * CacheStore constructor.
     *
     * @param string $service
     * @param CacheStoreOptions $options
     */
    public function __construct(string $service, CacheStoreOptions $options)
    {
        parent::__construct($service, $options);

        $this
            ->setCacheFactory($options->cacheFactory)
            ->prepareKeys();
    }

    /**
     * @inheritDoc
     */
    public function setState(State $state): bool
    {
        return $this->getCacheStore()->put(
            $this->stateKey,
            $this->toStore($state),
            $this->stateTtl($state)
        );
    }

    /**
     * @inheritDoc
     */
    public function getState(): State
    {
        $state = $this->getCacheStore()->get($this->stateKey);

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
        if (!($state instanceof Lockable)){
            throw new StateCannotBeLocked(sprintf('%s state cannot be locked', $state->name()));
        }

        /** @var \Illuminate\Contracts\Cache\Store|LockProvider $store */
        $store = $this->getCacheStore();
        $lock = $store->lock(
            $this->lockedStateKey,
            $this->stateTtl($state),
            $this->service
        );

        // Attempt acquire lock. If successfully, then the callback is invoked and
        // released. If not, then "false" is returned.
        return $lock->get($callback);
    }

    /**
     * @inheritDoc
     */
    public function registerFailure(Failure $failure): bool
    {
        $persisted = $this->getCacheStore()->forever(
            $this->lastFailureKey,
            $this->toStore($failure)
        );

        $this->incrementFailures();

        return $persisted;
    }

    /**
     * @inheritDoc
     */
    public function getFailure(): ?Failure
    {
        $failure = $this->getCacheStore()->get($this->lastFailureKey);

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
        $total = $this->getCacheStore()->increment($this->totalFailuresKey, $amount);

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
        $total = $this->getCacheStore()->get($this->totalFailuresKey);
        if (!isset($total)) {
            return 0;
        }

        return (int)$total;
    }

    /**
     * @inheritDoc
     */
    public function resetFailures(): Store
    {
        $store = $this->getCacheStore();

        $forgotTotal = $store->forget($this->totalFailuresKey);
        $forgotFailure = $store->forget($this->lastFailureKey);

        if ($forgotFailure === false || $forgotTotal === false) {
            throw new StoreException('Unable reset last registered failure / total failure amount');
        }

        return $this;
    }

    /*****************************************************************
     * Defaults
     ****************************************************************/

    /**
     * @inheritDoc
     */
    public function getDefaultCacheStore(): ?LaravelCacheStore
    {
        $repository = $this->getCacheFactory()->store(
            $this->getOption('cache-store')
        );

        $store = $repository->getStore();
        if (!($store instanceof LockProvider)) {
            throw new StoreException('Only "Lock Provider" cache-stores can be used by Circuit Breaker Cache Store');
        }

        return $store;
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

        return $this;
    }
}
