<?php

namespace Aedart\Contracts\Circuits\Failures;

use Aedart\Contracts\Circuits\Failure;
use DateTimeInterface;

/**
 * Failure Factory
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Circuits\Failures
 */
interface Factory
{
    /**
     * Creates a new failure instance
     *
     * @param string|null $reason [optional]
     * @param array $context [optional]
     * @param  DateTimeInterface|string|null  $reportedAt [optional]
     * @param int $totalFailures [optional]
     *
     * @return Failure
     */
    public function make(
        string|null $reason = null,
        array $context = [],
        DateTimeInterface|string|null $reportedAt = null,
        int $totalFailures = 0
    ): Failure;

    /**
     * Creates a new failure instance
     *
     * @param array $data
     *
     * @return Failure
     */
    public function makeFromArray(array $data): Failure;
}
