<?php

namespace Aedart\Contracts\Support\Helpers\Pipeline;

use Illuminate\Contracts\Pipeline\Hub;

/**
 * Pipeline Hub Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Helpers\Pipeline
 */
interface PipelineHubAware
{
    /**
     * Set pipeline hub
     *
     * @param  Hub|null  $hub  Pipeline Hub instance
     *
     * @return self
     */
    public function setPipelineHub(Hub|null $hub): static;

    /**
     * Get pipeline hub
     *
     * If no pipeline hub has been set, this method will
     * set and return a default pipeline hub, if any such
     * value is available
     *
     * @return Hub|null pipeline hub or null if none pipeline hub has been set
     */
    public function getPipelineHub(): Hub|null;

    /**
     * Check if pipeline hub has been set
     *
     * @return bool True if pipeline hub has been set, false if not
     */
    public function hasPipelineHub(): bool;

    /**
     * Get a default pipeline hub value, if any is available
     *
     * @return Hub|null A default pipeline hub value or Null if no default value is available
     */
    public function getDefaultPipelineHub(): Hub|null;
}
