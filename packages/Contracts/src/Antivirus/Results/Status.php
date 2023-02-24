<?php

namespace Aedart\Contracts\Antivirus\Results;

/**
 * File Scan Status
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Antivirus\Results
 */
interface Status
{
    /**
     * Create a new scan status instance from given value
     *
     * @param mixed|null $value [optional] When no value is given, then a default
     *                          unsuccessful status is return (e.g. "unknown").
     * @param string|null $reason [optional] Eventual failure reason
     *
     * @return static
     */
    public static function make(mixed $value = null, string|null $reason = null): static;

    /**
     * Determine if this status represents a successful state
     *
     * "successful" is when:
     * ```
     * a) Antivirus has scanned the file
     * b) No infections were found (virus, malware,...etc)
     * c) No scanning failure occurred, e.g. timeout, could not read file, filetype unsupported... etc
     * ```
     *
     * @return bool
     */
    public function isOk(): bool;

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
     * Get the value that is used to determine status success
     *
     * @return mixed
     */
    public function value(): mixed;
}
