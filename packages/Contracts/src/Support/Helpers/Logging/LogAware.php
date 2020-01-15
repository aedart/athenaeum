<?php

namespace Aedart\Contracts\Support\Helpers\Logging;

use Psr\Log\LoggerInterface;

/**
 * Log Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Helpers\Logging
 */
interface LogAware
{
    /**
     * Set log
     *
     * @param LoggerInterface|null $logger Logger instance
     *
     * @return self
     */
    public function setLog(?LoggerInterface $logger);

    /**
     * Get log
     *
     * If no log has been set, this method will
     * set and return a default log, if any such
     * value is available
     *
     * @see getDefaultLog()
     *
     * @return LoggerInterface|null log or null if none log has been set
     */
    public function getLog(): ?LoggerInterface;

    /**
     * Check if log has been set
     *
     * @return bool True if log has been set, false if not
     */
    public function hasLog(): bool;

    /**
     * Get a default log value, if any is available
     *
     * @return LoggerInterface|null A default log value or Null if no default value is available
     */
    public function getDefaultLog(): ?LoggerInterface;
}
