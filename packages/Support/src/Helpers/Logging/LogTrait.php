<?php

namespace Aedart\Support\Helpers\Logging;

use Illuminate\Support\Facades\Log;
use Psr\Log\LoggerInterface;

/**
 * Log Trait
 *
 * @see \Aedart\Contracts\Support\Helpers\Logging\LogAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Helpers\Logging
 */
trait LogTrait
{
    /**
     * Logger instance
     *
     * @var LoggerInterface|null
     */
    protected LoggerInterface|null $log = null;

    /**
     * Set log
     *
     * @param LoggerInterface|null $logger Logger instance
     *
     * @return self
     */
    public function setLog(LoggerInterface|null $logger): static
    {
        $this->log = $logger;

        return $this;
    }

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
    public function getLog(): LoggerInterface|null
    {
        if (!$this->hasLog()) {
            $this->setLog($this->getDefaultLog());
        }
        return $this->log;
    }

    /**
     * Check if log has been set
     *
     * @return bool True if log has been set, false if not
     */
    public function hasLog(): bool
    {
        return isset($this->log);
    }

    /**
     * Get a default log value, if any is available
     *
     * @return LoggerInterface|null A default log value or Null if no default value is available
     */
    public function getDefaultLog(): LoggerInterface|null
    {
        return Log::getFacadeRoot();
    }
}
