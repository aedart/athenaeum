<?php

namespace Aedart\Contracts\Support\Helpers\Logging;

/**
 * Log Manager Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Helpers\Logging
 */
interface LogManagerAware
{
    /**
     * Set log manager
     *
     * @param \Illuminate\Log\LogManager|null $manager Log Manager instance
     *
     * @return self
     */
    public function setLogManager($manager): static;

    /**
     * Get log manager
     *
     * If no log manager has been set, this method will
     * set and return a default log manager, if any such
     * value is available
     *
     * @see getDefaultLogManager()
     *
     * @return \Illuminate\Log\LogManager|null log manager or null if none log manager has been set
     */
    public function getLogManager();

    /**
     * Check if log manager has been set
     *
     * @return bool True if log manager has been set, false if not
     */
    public function hasLogManager(): bool;

    /**
     * Get a default log manager value, if any is available
     *
     * @return \Illuminate\Log\LogManager|null A default log manager value or Null if no default value is available
     */
    public function getDefaultLogManager();
}
