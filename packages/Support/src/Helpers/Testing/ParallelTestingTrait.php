<?php

namespace Aedart\Support\Helpers\Testing;

use Illuminate\Support\Facades\ParallelTesting as ParallelTestingFacade;
use Illuminate\Testing\ParallelTesting;

/**
 * Parallel Testing Trait
 *
 * @see \Aedart\Contracts\Support\Helpers\Testing\ParallelTestingAware
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Support\Helpers\Testing
 */
trait ParallelTestingTrait
{
    /**
     * Parallel Testing helper instance
     *
     * @var ParallelTesting|null
     */
    protected ParallelTesting|null $parallelTesting = null;

    /**
     * Set parallel testing
     *
     * @param \Illuminate\Testing\ParallelTesting|null $helper Parallel Testing helper instance
     *
     * @return self
     */
    public function setParallelTesting($helper): static
    {
        $this->parallelTesting = $helper;

        return $this;
    }

    /**
     * Get parallel testing
     *
     * If no parallel testing has been set, this method will
     * set and return a default parallel testing, if any such
     * value is available
     *
     * @return \Illuminate\Testing\ParallelTesting|null parallel testing or null if none parallel testing has been set
     */
    public function getParallelTesting()
    {
        if (!$this->hasParallelTesting()) {
            $this->setParallelTesting($this->getDefaultParallelTesting());
        }
        return $this->parallelTesting;
    }

    /**
     * Check if parallel testing has been set
     *
     * @return bool True if parallel testing has been set, false if not
     */
    public function hasParallelTesting(): bool
    {
        return isset($this->parallelTesting);
    }

    /**
     * Get a default parallel testing value, if any is available
     *
     * @return \Illuminate\Testing\ParallelTesting|null A default parallel testing value or Null if no default value is available
     */
    public function getDefaultParallelTesting()
    {
        return ParallelTestingFacade::getFacadeRoot();
    }
}
