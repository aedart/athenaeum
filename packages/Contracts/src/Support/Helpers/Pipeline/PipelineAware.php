<?php

namespace Aedart\Contracts\Support\Helpers\Pipeline;

use Illuminate\Contracts\Pipeline\Pipeline;

/**
 * Pipeline Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Helpers\Pipeline
 */
interface PipelineAware
{
    /**
     * Set pipeline
     *
     * @param  Pipeline|null  $pipeline  Pipeline instance
     *
     * @return self
     */
    public function setPipeline(Pipeline|null $pipeline): static;

    /**
     * Get pipeline
     *
     * If no pipeline has been set, this method will
     * set and return a default pipeline, if any such
     * value is available
     *
     * @return Pipeline|null pipeline or null if none pipeline has been set
     */
    public function getPipeline(): Pipeline|null;

    /**
     * Check if pipeline has been set
     *
     * @return bool True if pipeline has been set, false if not
     */
    public function hasPipeline(): bool;

    /**
     * Get a default pipeline value, if any is available
     *
     * @return Pipeline|null A default pipeline value or Null if no default value is available
     */
    public function getDefaultPipeline(): Pipeline|null;
}
