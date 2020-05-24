<?php

namespace Aedart\Circuits\Traits;

use Aedart\Contracts\Circuits\Manager;
use Aedart\Support\Facades\IoCFacade;

/**
 * Circuit Breaker Manager Trait
 *
 * @see \Aedart\Contracts\Circuits\Managers\CircuitBreakerManagerAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Circuits\Traits
 */
trait CircuitBreakerManagerTrait
{
    /**
     * Circuit Breaker Manager instance
     *
     * @var Manager|null
     */
    protected ?Manager $circuitBreakerManager = null;

    /**
     * Set circuit breaker manager
     *
     * @param Manager|null $manager Circuit Breaker Manager instance
     *
     * @return self
     */
    public function setCircuitBreakerManager(?Manager $manager)
    {
        $this->circuitBreakerManager = $manager;

        return $this;
    }

    /**
     * Get circuit breaker manager
     *
     * If no circuit breaker manager has been set, this method will
     * set and return a default circuit breaker manager, if any such
     * value is available
     *
     * @return Manager|null circuit breaker manager or null if none circuit breaker manager has been set
     */
    public function getCircuitBreakerManager(): ?Manager
    {
        if (!$this->hasCircuitBreakerManager()) {
            $this->setCircuitBreakerManager($this->getDefaultCircuitBreakerManager());
        }
        return $this->circuitBreakerManager;
    }

    /**
     * Check if circuit breaker manager has been set
     *
     * @return bool True if circuit breaker manager has been set, false if not
     */
    public function hasCircuitBreakerManager(): bool
    {
        return isset($this->circuitBreakerManager);
    }

    /**
     * Get a default circuit breaker manager value, if any is available
     *
     * @return Manager|null A default circuit breaker manager value or Null if no default value is available
     */
    public function getDefaultCircuitBreakerManager(): ?Manager
    {
        return IoCFacade::tryMake(Manager::class);
    }
}
