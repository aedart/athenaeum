<?php

namespace Aedart\Circuits\Failures;

use Aedart\Contracts\Circuits\Failure;
use Aedart\Contracts\Circuits\Failures\Factory as FailureFactory;

/**
 * Failure Factory
 *
 * @see \Aedart\Contracts\Circuits\Failures\Factory
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Circuits\Failures
 */
class Factory implements FailureFactory
{
    /**
     * @inheritDoc
     */
    public function make(
        ?string $reason = null,
        array $context = [],
        $reportedAt = null,
        int $totalFailures = 0
    ): Failure {
        return $this->makeByArray([
            'reason' => $reason,
            'context' => $context,
            'reported_at' => $reportedAt,
            'total_failures' => $totalFailures
        ]);
    }

    /**
     * @inheritDoc
     */
    public function makeByArray(array $data): Failure
    {
        return new CircuitBreakerFailure($data);
    }
}
