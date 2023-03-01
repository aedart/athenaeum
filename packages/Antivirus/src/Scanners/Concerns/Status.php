<?php

namespace Aedart\Antivirus\Scanners\Concerns;

use Aedart\Contracts\Antivirus\Exceptions\UnsupportedStatusValueException;
use Aedart\Contracts\Antivirus\Results\Status as ScanStatus;

/**
 * Concerns Scan Status
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Antivirus\Scanners\Concerns
 */
trait Status
{
    /**
     * Return class path to file scan status
     *
     * @return class-string<ScanStatus>
     */
    abstract protected function statusClass(): string;

    /**
     * Creates a new file scan status instance
     *
     * @param mixed $value
     * @param string|null $reason [optional]
     *
     * @return ScanStatus
     *
     * @throws UnsupportedStatusValueException
     */
    protected function makeScanStatus(mixed $value, string|null $reason = null): ScanStatus
    {
        $class = $this->statusClass();

        return $class::make($value, $reason);
    }
}
