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
     * Determine if request's preconditions must be evaluated or not
     *
     * @return bool
     */
    public function mustEvaluatePreconditions(): bool;
}
