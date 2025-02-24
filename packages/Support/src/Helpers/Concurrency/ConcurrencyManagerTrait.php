<?php

namespace Aedart\Support\Helpers\Concurrency;

use Illuminate\Concurrency\ConcurrencyManager;
use Illuminate\Support\Facades\Concurrency;

/**
 * Concurrency Manager Trait
 *
 * @see \Aedart\Contracts\Support\Helpers\Concurrency\ConcurrencyManagerAware
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Support\Helpers\Concurrency
 */
trait ConcurrencyManagerTrait
{
    /**
     * Concurrency Manager instance
     *
     * @var ConcurrencyManager|null
     */
    protected ConcurrencyManager|null $concurrencyManager = null;

    /**
     * Set concurrency manager
     *
     * @param \Illuminate\Concurrency\ConcurrencyManager|null $manager Concurrency Manager instance
     *
     * @return self
     */
    public function setConcurrencyManager($manager): static
    {
        $this->concurrencyManager = $manager;

        return $this;
    }

    /**
     * Get concurrency manager
     *
     * If no concurrency manager has been set, this method will
     * set and return a default concurrency manager, if any such
     * value is available
     *
     * @return \Illuminate\Concurrency\ConcurrencyManager|null concurrency manager or null if none concurrency manager has been set
     */
    public function getConcurrencyManager()
    {
        if (!$this->hasConcurrencyManager()) {
            $this->setConcurrencyManager($this->getDefaultConcurrencyManager());
        }
        return $this->concurrencyManager;
    }

    /**
     * Check if concurrency manager has been set
     *
     * @return bool True if concurrency manager has been set, false if not
     */
    public function hasConcurrencyManager(): bool
    {
        return isset($this->concurrencyManager);
    }

    /**
     * Get a default concurrency manager value, if any is available
     *
     * @return \Illuminate\Concurrency\ConcurrencyManager|null A default concurrency manager value or Null if no default value is available
     */
    public function getDefaultConcurrencyManager()
    {
        return Concurrency::getFacadeRoot();
    }
}