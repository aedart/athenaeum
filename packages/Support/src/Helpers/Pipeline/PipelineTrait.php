<?php

namespace Aedart\Support\Helpers\Pipeline;

use Illuminate\Contracts\Pipeline\Pipeline;
use Illuminate\Support\Facades\Pipeline as PipelineFacade;

/**
 * Pipeline Trait
 *
 * @see \Aedart\Contracts\Support\Helpers\Pipeline\PipelineAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Helpers\Pipeline
 */
trait PipelineTrait
{
    /**
     * Pipeline instance
     *
     * @var Pipeline|null
     */
    protected Pipeline|null $pipeline = null;

    /**
     * Set pipeline
     *
     * @param  Pipeline|null  $pipeline  Pipeline instance
     *
     * @return self
     */
    public function setPipeline(Pipeline|null $pipeline): static
    {
        $this->pipeline = $pipeline;

        return $this;
    }

    /**
     * Get pipeline
     *
     * If no pipeline has been set, this method will
     * set and return a default pipeline, if any such
     * value is available
     *
     * @return Pipeline|null pipeline or null if none pipeline has been set
     */
    public function getPipeline(): Pipeline|null
    {
        if (!$this->hasPipeline()) {
            $this->setPipeline($this->getDefaultPipeline());
        }
        return $this->pipeline;
    }

    /**
     * Check if pipeline has been set
     *
     * @return bool True if pipeline has been set, false if not
     */
    public function hasPipeline(): bool
    {
        return isset($this->pipeline);
    }

    /**
     * Get a default pipeline value, if any is available
     *
     * @return Pipeline|null A default pipeline value or Null if no default value is available
     */
    public function getDefaultPipeline(): Pipeline|null
    {
        return PipelineFacade::getFacadeRoot();
    }
}
