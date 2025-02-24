<?php

namespace Aedart\Contracts\Support\Helpers\Process;

/**
 * Process Factory Aware
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Contracts\Support\Helpers\Process
 */
interface ProcessFactoryAware
{
    /**
     * Set process factory
     *
     * @param \Illuminate\Process\Factory|null $factory Process Factory instance
     *
     * @return self
     */
    public function setProcessFactory($factory): static;

    /**
     * Get process factory
     *
     * If no process factory has been set, this method will
     * set and return a default process factory, if any such
     * value is available
     *
     * @return \Illuminate\Process\Factory|null process factory or null if none process factory has been set
     */
    public function getProcessFactory();

    /**
     * Check if process factory has been set
     *
     * @return bool True if process factory has been set, false if not
     */
    public function hasProcessFactory(): bool;

    /**
     * Get a default process factory value, if any is available
     *
     * @return \Illuminate\Process\Factory|null A default process factory value or Null if no default value is available
     */
    public function getDefaultProcessFactory();
}
