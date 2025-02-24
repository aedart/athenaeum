<?php

namespace Aedart\Contracts\Support\Helpers\Concurrency;

/**
 * Concurrency Manager Trait
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Support\Helpers\Concurrency
 */
interface ConcurrencyManagerAware
{
    /**
     * Set concurrency manager
     *
     * @param \Illuminate\Concurrency\ConcurrencyManager|null $manager Concurrency Manager instance
     *
     * @return self
     */
    public function setConcurrencyManager($manager): static;

    /**
     * Get concurrency manager
     *
     * If no concurrency manager has been set, this method will
     * set and return a default concurrency manager, if any such
     * value is available
     *
     * @return \Illuminate\Concurrency\ConcurrencyManager|null concurrency manager or null if none concurrency manager has been set
     */
    public function getConcurrencyManager();

    /**
     * Check if concurrency manager has been set
     *
     * @return bool True if concurrency manager has been set, false if not
     */
    public function hasConcurrencyManager(): bool;

    /**
     * Get a default concurrency manager value, if any is available
     *
     * @return \Illuminate\Concurrency\ConcurrencyManager|null A default concurrency manager value or Null if no default value is available
     */
    public function getDefaultConcurrencyManager();
}