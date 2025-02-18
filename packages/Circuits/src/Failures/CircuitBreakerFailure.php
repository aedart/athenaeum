<?php

namespace Aedart\Circuits\Failures;

use Aedart\Circuits\Concerns;
use Aedart\Contracts\Circuits\Failure;
use DateTimeInterface;

/**
 * Circuit Breaker Failure
 *
 * @see \Aedart\Contracts\Circuits\Failure
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Circuits\Failures
 */
class CircuitBreakerFailure implements Failure
{
    use Concerns\Dates;
    use Concerns\Importable;
    use Concerns\Exportable;
    use Concerns\Context;

    /**
     * Failure reason
     *
     * @var string|null
     */
    protected string|null $reason = null;

    /**
     * Date and time of when this failure was reported
     *
     * @var DateTimeInterface
     */
    protected DateTimeInterface $reportedAt;

    /**
     * Total amount of failures reported, at the time
     * when this failure was reported.
     *
     * @var int
     */
    protected int $totalFailures = 0;

    /**
     * CircuitBreakerFailure constructor.
     *
     * @param array $data [optional]
     */
    public function __construct(array $data = [])
    {
        $this->populate($data);
    }

    /**
     * Create a new circuit breaker failure instance
     *
     * @param array $data [optional]
     *
     * @return static
     */
    public static function make(array $data = []): static
    {
        return new static($data);
    }

    /**
     * @inheritDoc
     */
    public function reason(): string|null
    {
        return $this->reason;
    }

    /**
     * @inheritDoc
     */
    public function reportedAt(): DateTimeInterface
    {
        return $this->reportedAt;
    }

    /**
     * @inheritDoc
     */
    public function totalFailures(): int
    {
        return $this->totalFailures;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'reason' => $this->reason(),
            'context' => $this->context(),
            'reported_at' => $this->formatDate($this->reportedAt()),
            'total_failures' => $this->totalFailures()
        ];
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * @inheritDoc
     */
    protected function populate(array $data): static
    {
        return $this
            ->setReason($data['reason'] ?? null)
            ->setContext($data['context'] ?? [])
            ->setReportedAt($data['reported_at'] ?? null)
            ->setTotalFailures($data['total_failures'] ?? 0);
    }

    /**
     * Set the failure reason
     *
     * @param string|null $reason [optional]
     *
     * @return self
     */
    protected function setReason(string|null $reason = null): static
    {
        $this->reason = $reason;

        return $this;
    }

    /**
     * Set the date and time of when this failure was reported
     *
     * @param  DateTimeInterface|string|null  $reportedAt [optional]
     *
     * @return self
     */
    protected function setReportedAt(DateTimeInterface|string|null $reportedAt = null): static
    {
        $this->reportedAt = $this->resolveDate($reportedAt);

        return $this;
    }

    /**
     * Set total amount of failures reported, at the time of
     * when this failure was reported
     *
     * @param int $amount [optional]
     *
     * @return self
     */
    protected function setTotalFailures(int $amount = 0): static
    {
        $this->totalFailures = $amount;

        return $this;
    }
}
