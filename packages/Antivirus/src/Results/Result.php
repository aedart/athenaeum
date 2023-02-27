<?php

namespace Aedart\Antivirus\Results;

use Aedart\Contracts\Antivirus\Results\ScanResult;
use Aedart\Contracts\Antivirus\Results\Status;
use Aedart\Contracts\Utils\Dates\DateTimeFormats;
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
     * @param string $filepath
     * @param int $filesize
     * @param string|null $filename [optional]
     * @param array $details [optional]
     * @param string|int|null $user [optional]
     * @param DateTimeInterface|null $datetime [optional]
     */
    public function __construct(
        protected Status $status,
        protected string $filepath,
        protected int $filesize,
        protected string|null $filename = null,
        protected array $details = [],
        protected string|int|null $user = null,
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
    public function filepath(): string
    {
        return $this->filepath;
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
    public function user(): string|int|null
    {
        return $this->user;
    }

    /**
     * @inheritDoc
     */
    public function details(): array
    {
        return $this->details;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'status' => (string) $this->status(),
            'filename' => $this->filename(),
            'filepath' => $this->filepath(),
            'filesize' => $this->filesize(),
            'datetime' => $this->formatDatetime($this->datetime()),
            'user' => $this->user(),
            'details' => $this->details()
        ];
    }

    /**
     * Formats the datetime instance
     *
     * @param DateTimeInterface $datetime
     *
     * @return string
     */
    protected function formatDatetime(DateTimeInterface $datetime): string
    {
        return $datetime->format(DateTimeFormats::RFC3339_EXTENDED_ZULU);
    }
}
