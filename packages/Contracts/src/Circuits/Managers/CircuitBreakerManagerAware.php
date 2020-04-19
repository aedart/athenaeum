<?php

namespace Aedart\Contracts\Circuits\Managers;

use Aedart\Contracts\Circuits\Manager;

/**
 * Circuit Breaker Manager Aware
 *
 * @see \Aedart\Contracts\Circuits\Manager
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Circuits\Managers
 */
interface CircuitBreakerManagerAware
{
    /**
     * Set circuit breaker manager
     *
     * @param Manager|null $manager Circuit Breaker Manager instance
     *
     * @return self
     */
    public function setCircuitBreakerManager(?Manager $manager);

    /**
     * Get circuit breaker manager
     *
     * If no circuit breaker manager has been set, this method will
     * set and return a default circuit breaker manager, if any such
     * value is available
     *
     * @return Manager|null circuit breaker manager or null if none circuit breaker manager has been set
     */
    public function getCircuitBreakerManager(): ?Manager;

    /**
     * Check if circuit breaker manager has been set
     *
     * @return bool True if circuit breaker manager has been set, false if not
     */
    public function hasCircuitBreakerManager(): bool;

    /**
     * Get a default circuit breaker manager value, if any is available
     *
     * @return Manager|null A default circuit breaker manager value or Null if no default value is available
     */
    public function getDefaultCircuitBreakerManager(): ?Manager;
}
