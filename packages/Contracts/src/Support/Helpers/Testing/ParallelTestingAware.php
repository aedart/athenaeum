<?php

namespace Aedart\Contracts\Support\Helpers\Testing;

/**
 * Parallel Testing Aware
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Contracts\Support\Helpers\Testing
 */
interface ParallelTestingAware
{
    /**
     * Set parallel testing
     *
     * @param \Illuminate\Testing\ParallelTesting|null $helper Parallel Testing helper instance
     *
     * @return self
     */
    public function setParallelTesting($helper): static;

    /**
     * Get parallel testing
     *
     * If no parallel testing has been set, this method will
     * set and return a default parallel testing, if any such
     * value is available
     *
     * @return \Illuminate\Testing\ParallelTesting|null parallel testing or null if none parallel testing has been set
     */
    public function getParallelTesting();

    /**
     * Check if parallel testing has been set
     *
     * @return bool True if parallel testing has been set, false if not
     */
    public function hasParallelTesting(): bool;

    /**
     * Get a default parallel testing value, if any is available
     *
     * @return \Illuminate\Testing\ParallelTesting|null A default parallel testing value or Null if no default value is available
     */
    public function getDefaultParallelTesting();
}
