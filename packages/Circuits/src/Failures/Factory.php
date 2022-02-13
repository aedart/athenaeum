<?php

namespace Aedart\Circuits\Failures;

use Aedart\Contracts\Circuits\Failure;
use Aedart\Contracts\Circuits\Failures\Factory as FailureFactory;
use DateTimeInterface;

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
        string|null $reason = null,
        array $context = [],
        DateTimeInterface|string|null $reportedAt = null,
        int $totalFailures = 0
    ): Failure
    {
        return $this->makeFromArray([
            'reason' => $reason,
            'context' => $context,
            'reported_at' => $reportedAt,
            'total_failures' => $totalFailures
        ]);
    }

    /**
     * @inheritDoc
     */
    public function makeFromArray(array $data): Failure
    {
        return new CircuitBreakerFailure($data);
    }
}
