<?php

namespace Aedart\Circuits\Traits;

use Aedart\Contracts\Circuits\CircuitBreaker;

/**
 * Circuit Breaker Trait
 *
 * @see \Aedart\Contracts\Circuits\CircuitBreakerAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Circuits\Traits
 */
trait CircuitBreakerTrait
{
    /**
     * Circuit Breaker instance
     *
     * @var CircuitBreaker|null
     */
    protected ?CircuitBreaker $circuitBreaker = null;

    /**
     * Set circuit breaker
     *
     * @param CircuitBreaker|null $circuitBreaker Circuit Breaker instance
     *
     * @return self
     */
    public function setCircuitBreaker(?CircuitBreaker $circuitBreaker)
    {
        $this->circuitBreaker = $circuitBreaker;

        return $this;
    }

    /**
     * Get circuit breaker
     *
     * If no circuit breaker has been set, this method will
     * set and return a default circuit breaker, if any such
     * value is available
     *
     * @return CircuitBreaker|null circuit breaker or null if none circuit breaker has been set
     */
    public function getCircuitBreaker(): ?CircuitBreaker
    {
        if (!$this->hasCircuitBreaker()) {
            $this->setCircuitBreaker($this->getDefaultCircuitBreaker());
        }
        return $this->circuitBreaker;
    }

    /**
     * Check if circuit breaker has been set
     *
     * @return bool True if circuit breaker has been set, false if not
     */
    public function hasCircuitBreaker(): bool
    {
        return isset($this->circuitBreaker);
    }

    /**
     * Get a default circuit breaker value, if any is available
     *
     * @return CircuitBreaker|null A default circuit breaker value or Null if no default value is available
     */
    public function getDefaultCircuitBreaker(): ?CircuitBreaker
    {
        return null;
    }
}
