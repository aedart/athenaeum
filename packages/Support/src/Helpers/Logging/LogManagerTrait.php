<?php

namespace Aedart\Support\Helpers\Logging;

use Illuminate\Log\LogManager;
use Illuminate\Support\Facades\Log;

/**
 * Log Manager Trait
 *
 * @see \Aedart\Contracts\Support\Helpers\Logging\LogManagerAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Helpers\Logging
 */
trait LogManagerTrait
{
    /**
     * Log Manager instance
     *
     * @var LogManager|null
     */
    protected LogManager|null $logManager = null;

    /**
     * Set log manager
     *
     * @param LogManager|null $manager Log Manager instance
     *
     * @return self
     */
    public function setLogManager($manager): static
    {
        $this->logManager = $manager;

        return $this;
    }

    /**
     * Get log manager
     *
     * If no log manager has been set, this method will
     * set and return a default log manager, if any such
     * value is available
     *
     * @see getDefaultLogManager()
     *
     * @return LogManager|null log manager or null if none log manager has been set
     */
    public function getLogManager()
    {
        if (!$this->hasLogManager()) {
            $this->setLogManager($this->getDefaultLogManager());
        }
        return $this->logManager;
    }

    /**
     * Check if log manager has been set
     *
     * @return bool True if log manager has been set, false if not
     */
    public function hasLogManager(): bool
    {
        return isset($this->logManager);
    }

    /**
     * Get a default log manager value, if any is available
     *
     * @return LogManager|null A default log manager value or Null if no default value is available
     */
    public function getDefaultLogManager()
    {
        return Log::getFacadeRoot();
    }
}
