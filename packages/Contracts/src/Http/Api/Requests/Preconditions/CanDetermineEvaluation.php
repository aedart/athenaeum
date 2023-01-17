<?php

namespace Aedart\Contracts\Http\Api\Requests\Preconditions;

/**
 * Can Determine Preconditions Evaluation
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Http\Api\Requests\Preconditions
 */
interface CanDetermineEvaluation
{
    /**
     * Determine whether this request supports preconditions or not.
     *
     * When true, then request must evaluate request's preconditions.
     * Otherwise, the request MUST ignore them.
     *
     * @return bool
     */
    public function mustEvaluatePreconditions(): bool;
}
