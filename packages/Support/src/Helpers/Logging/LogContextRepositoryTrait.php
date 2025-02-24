<?php

namespace Aedart\Support\Helpers\Logging;

use Illuminate\Log\Context\Repository;
use Illuminate\Support\Facades\Context;

/**
 * Log Context Repository Trait
 *
 * @see \Aedart\Contracts\Support\Helpers\Logging\LogContextRepositoryAware
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Support\Helpers\Logging
 */
trait LogContextRepositoryTrait
{
    /**
     * Log Context Repository instance
     *
     * @var Repository|null
     */
    protected Repository|null $logContextRepository = null;

    /**
     * Set log context repository
     *
     * @param \Illuminate\Log\Context\Repository|null $repository Log Context Repository instance
     *
     * @return self
     */
    public function setLogContextRepository($repository): static
    {
        $this->logContextRepository = $repository;

        return $this;
    }

    /**
     * Get log context repository
     *
     * If no log context repository has been set, this method will
     * set and return a default log context repository, if any such
     * value is available
     *
     * @return \Illuminate\Log\Context\Repository|null log context repository or null if none log context repository has been set
     */
    public function getLogContextRepository()
    {
        if (!$this->hasLogContextRepository()) {
            $this->setLogContextRepository($this->getDefaultLogContextRepository());
        }
        return $this->logContextRepository;
    }

    /**
     * Check if log context repository has been set
     *
     * @return bool True if log context repository has been set, false if not
     */
    public function hasLogContextRepository(): bool
    {
        return isset($this->logContextRepository);
    }

    /**
     * Get a default log context repository value, if any is available
     *
     * @return \Illuminate\Log\Context\Repository|null A default log context repository value or Null if no default value is available
     */
    public function getDefaultLogContextRepository()
    {
        return Context::getFacadeRoot();
    }
}
