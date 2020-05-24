<?php

namespace Aedart\Contracts\Circuits;

/**
 * Circuit Breaker Aware
 *
 * @see \Aedart\Contracts\Circuits\CircuitBreaker
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Circuits
 */
interface CircuitBreakerAware
{
    /**
     * Set circuit breaker
     *
     * @param CircuitBreaker|null $circuitBreaker Circuit Breaker instance
     *
     * @return self
     */
    public function setCircuitBreaker(?CircuitBreaker $circuitBreaker);

    /**
     * Get circuit breaker
     *
     * If no circuit breaker has been set, this method will
     * set and return a default circuit breaker, if any such
     * value is available
     *
     * @return CircuitBreaker|null circuit breaker or null if none circuit breaker has been set
     */
    public function getCircuitBreaker(): ?CircuitBreaker;

    /**
     * Check if circuit breaker has been set
     *
     * @return bool True if circuit breaker has been set, false if not
     */
    public function hasCircuitBreaker(): bool;

    /**
     * Get a default circuit breaker value, if any is available
     *
     * @return CircuitBreaker|null A default circuit breaker value or Null if no default value is available
     */
    public function getDefaultCircuitBreaker(): ?CircuitBreaker;
}
