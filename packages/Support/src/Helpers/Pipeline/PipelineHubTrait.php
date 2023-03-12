<?php

namespace Aedart\Support\Helpers\Pipeline;

use Aedart\Support\Facades\IoCFacade;
use Illuminate\Contracts\Pipeline\Hub;

/**
 * Pipeline Hub Trait
 *
 * @see \Aedart\Contracts\Support\Helpers\Pipeline\PipelineHubAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Helpers\Pipeline
 */
trait PipelineHubTrait
{
    /**
     * Pipeline Hub instance
     *
     * @var Hub|null
     */
    protected Hub|null $pipelineHub = null;

    /**
     * Set pipeline hub
     *
     * @param  Hub|null  $hub  Pipeline Hub instance
     *
     * @return self
     */
    public function setPipelineHub(Hub|null $hub): static
    {
        $this->pipelineHub = $hub;

        return $this;
    }

    /**
     * Get pipeline hub
     *
     * If no pipeline hub has been set, this method will
     * set and return a default pipeline hub, if any such
     * value is available
     *
     * @return Hub|null pipeline hub or null if none pipeline hub has been set
     */
    public function getPipelineHub(): Hub|null
    {
        if (!$this->hasPipelineHub()) {
            $this->setPipelineHub($this->getDefaultPipelineHub());
        }
        return $this->pipelineHub;
    }

    /**
     * Check if pipeline hub has been set
     *
     * @return bool True if pipeline hub has been set, false if not
     */
    public function hasPipelineHub(): bool
    {
        return isset($this->pipelineHub);
    }

    /**
     * Get a default pipeline hub value, if any is available
     *
     * @return Hub|null A default pipeline hub value or Null if no default value is available
     */
    public function getDefaultPipelineHub(): Hub|null
    {
        return IoCFacade::tryMake(Hub::class);
    }
}
