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
     * When true, then preconditions MUST be evaluated by this request.
     * Otherwise, they must be ignored.
     *
     * @return bool
     */
    public function mustEvaluatePreconditions(): bool;
}
