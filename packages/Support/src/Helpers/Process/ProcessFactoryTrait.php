<?php

namespace Aedart\Support\Helpers\Process;

use Illuminate\Process\Factory;
use Illuminate\Support\Facades\Process;

/**
 * Process Factory Trait
 *
 * @see \Aedart\Contracts\Support\Helpers\Process\ProcessFactoryAware
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Support\Helpers\Process
 */
trait ProcessFactoryTrait
{
    /**
     * Process Factory instance
     *
     * @var Factory|null
     */
    protected Factory|null $processFactory = null;

    /**
     * Set process factory
     *
     * @param \Illuminate\Process\Factory|null $factory Process Factory instance
     *
     * @return self
     */
    public function setProcessFactory($factory): static
    {
        $this->processFactory = $factory;

        return $this;
    }

    /**
     * Get process factory
     *
     * If no process factory has been set, this method will
     * set and return a default process factory, if any such
     * value is available
     *
     * @return \Illuminate\Process\Factory|null process factory or null if none process factory has been set
     */
    public function getProcessFactory()
    {
        if (!$this->hasProcessFactory()) {
            $this->setProcessFactory($this->getDefaultProcessFactory());
        }
        return $this->processFactory;
    }

    /**
     * Check if process factory has been set
     *
     * @return bool True if process factory has been set, false if not
     */
    public function hasProcessFactory(): bool
    {
        return isset($this->processFactory);
    }

    /**
     * Get a default process factory value, if any is available
     *
     * @return \Illuminate\Process\Factory|null A default process factory value or Null if no default value is available
     */
    public function getDefaultProcessFactory()
    {
        return Process::getFacadeRoot();
    }
}
