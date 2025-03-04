<?php

namespace Aedart\Contracts\Support\Helpers\Logging;

/**
 * Log Context Repository Aware
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Contracts\Support\Helpers\Logging\Context
 */
interface LogContextRepositoryAware
{
    /**
     * Set log context repository
     *
     * @param \Illuminate\Log\Context\Repository|null $repository Log Context Repository instance
     *
     * @return self
     */
    public function setLogContextRepository($repository): static;

    /**
     * Get log context repository
     *
     * If no log context repository has been set, this method will
     * set and return a default log context repository, if any such
     * value is available
     *
     * @return \Illuminate\Log\Context\Repository|null log context repository or null if none log context repository has been set
     */
    public function getLogContextRepository();

    /**
     * Check if log context repository has been set
     *
     * @return bool True if log context repository has been set, false if not
     */
    public function hasLogContextRepository(): bool;

    /**
     * Get a default log context repository value, if any is available
     *
     * @return \Illuminate\Log\Context\Repository|null A default log context repository value or Null if no default value is available
     */
    public function getDefaultLogContextRepository();
}
