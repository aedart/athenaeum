<?php

namespace Aedart\Contracts\Circuits\Failures;

/**
 * Failure Factory Aware
 *
 * @see \Aedart\Contracts\Circuits\Failures\Factory
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Circuits\Failures
 */
interface FailureFactoryAware
{
    /**
     * Set failure factory
     *
     * @param Factory|null $factory Failure Factory instance
     *
     * @return self
     */
    public function setFailureFactory(Factory|null $factory): static;

    /**
     * Get failure factory
     *
     * If no failure factory has been set, this method will
     * set and return a default failure factory, if any such
     * value is available
     *
     * @return Factory|null failure factory or null if none failure factory has been set
     */
    public function getFailureFactory(): Factory|null;

    /**
     * Check if failure factory has been set
     *
     * @return bool True if failure factory has been set, false if not
     */
    public function hasFailureFactory(): bool;

    /**
     * Get a default failure factory value, if any is available
     *
     * @return Factory|null A default failure factory value or Null if no default value is available
     */
    public function getDefaultFailureFactory(): Factory|null;
}
