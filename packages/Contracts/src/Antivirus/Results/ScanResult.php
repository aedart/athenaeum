<?php

namespace Aedart\Contracts\Antivirus\Results;

use DateTimeInterface;
use Illuminate\Contracts\Support\Arrayable;

/**
 * File Scan Result
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Antivirus\Results
 */
interface ScanResult extends Arrayable
{
    /**
     * Determine if the scan was successful
     *
     * @see \Aedart\Contracts\Antivirus\Results\Status::isOk
     *
     * @return bool
     */
    public function isOk(): bool;

    /**
     * Determine if the scan has failed
     *
     * Opposite of {@see isOk}.
     *
     * @return bool
     */
    public function hasFailed(): bool;

    /**
     * Returns the file's scan status
     *
     * @return Status
     */
    public function status(): Status;

    /**
     * Get reason for failure
     *
     * @return string|null
     */
    public function reason(): string|null;

    /**
     * Determine if a failure reason is available
     *
     * @return bool
     */
    public function hasReason(): bool;

    /**
     * Get the name of the file that was scanned
     *
     * @return string
     */
    public function filename(): string;

    /**
     * Get the scanned file's size
     *
     * @return int bytes
     */
    public function filesize(): int;

    /**
     * Get the date and time of when the file was scanned
     *
     * @return DateTimeInterface
     */
    public function datetime(): DateTimeInterface;

    /**
     * Get eventual user that performed the scan
     *
     * @return string|int|null User identifier, e.g. username, email or database id,
     *                     if a user was identified.
     */
    public function user(): string|int|null;

    /**
     * Get additional details, if available
     *
     * @return array
     */
    public function details(): array;
}
