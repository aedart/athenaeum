<?php

namespace Aedart\Antivirus\Scanners\Concerns;

use Aedart\Contracts\Antivirus\Results\ScanResult;
use Aedart\Contracts\Antivirus\Results\Status;
use Aedart\Support\Facades\IoCFacade;
use DateTimeInterface;

/**
 * Concerns Scan Results
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Antivirus\Scanners\Concerns
 */
trait Results
{
    /**
     * Creates a new file scan result instance
     *
     * @param Status $status
     * @param string $filename
     * @param int $filesize
     * @param array $details [optional]
     * @param string|int|null $user [optional]
     * @param DateTimeInterface|null $datetime [optional]
     *
     * @return ScanResult
     */
    protected function makeScanResult(
        Status $status,
        string $filename,
        int $filesize,
        array $details = [],
        string|int|null $user = null,
        DateTimeInterface|null $datetime = null
    ): ScanResult {
        return IoCFacade::make(ScanResult::class, [
            'status' => $status,
            'filename' => $filename,
            'filesize' => $filesize,
            'details' => $details,
            'user' => $user ?? $this->user(),
            'datetime' => $datetime
        ]);
    }
}