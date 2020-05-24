<?php

namespace Aedart\Contracts\Circuits\Events;

use Aedart\Contracts\Circuits\Failure;

/**
 * Failure Reported
 *
 * Should be dispatched whenever a failure is reported.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Circuits\Events
 */
interface FailureReported extends CircuitBreakerEvent
{
    /**
     * The reported failure
     *
     * @return Failure
     */
    public function failure(): Failure;
}
