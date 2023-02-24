<?php

namespace Aedart\Antivirus\Results;

use Aedart\Contracts\Antivirus\Results\ScanResult;
use Aedart\Contracts\Antivirus\Results\Status;
use DateTimeInterface;
use Illuminate\Support\Facades\Date;

/**
 * Scan Result
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Antivirus\Results
 */
class Result implements ScanResult
{
    /**
     * Date and time of when scanning was completed
     *
     * @var DateTimeInterface
     */
    protected DateTimeInterface $datetime;

    /**
     * Create a new file scan result instance
     *
     * @param Status $status
     * @param string $filename
     * @param int $filesize
     * @param array $details [optional]
     * @param DateTimeInterface|null $datetime [optional]
     */
    public function __construct(
        protected Status $status,
        protected string $filename,
        protected int $filesize,
        protected array $details = [],
        DateTimeInterface|null $datetime = null,
    ) {
        $this->datetime = $datetime ?? Date::now()->toImmutable();
    }

    /**
     * @inheritDoc
     */
    public function isOk(): bool
    {
        return $this->status()->isOk();
    }

    /**
     * @inheritDoc
     */
    public function hasFailed(): bool
    {
        return !$this->isOk();
    }

    /**
     * @inheritDoc
     */
    public function status(): Status
    {
        return $this->status;
    }

    /**
     * @inheritDoc
     */
    public function reason(): string|null
    {
        return $this->status()->reason();
    }

    /**
     * @inheritDoc
     */
    public function hasReason(): bool
    {
        return $this->status()->hasReason();
    }

    /**
     * @inheritDoc
     */
    public function filename(): string
    {
        return $this->filename;
    }

    /**
     * @inheritDoc
     */
    public function filesize(): int
    {
        return $this->filesize;
    }

    /**
     * @inheritDoc
     */
    public function datetime(): DateTimeInterface
    {
        return $this->datetime;
    }

    /**
     * @inheritDoc
     */
    public function details(): array
    {
        return $this->details;
    }
}
