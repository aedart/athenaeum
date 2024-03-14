<?php

namespace Aedart\Antivirus\Scanners\Concerns;

use Aedart\Contracts\Antivirus\Results\ScanResult;
use Aedart\Contracts\Antivirus\Results\Status;
use Aedart\Contracts\Streams\FileStream;
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
     * @param  Status  $status
     * @param  FileStream  $file
     * @param  array  $details  [optional]
     * @param  string|int|null  $user  [optional]
     * @param  DateTimeInterface|null  $datetime  [optional]
     *
     * @return ScanResult
     */
    protected function makeScanResult(
        Status $status,
        FileStream $file,
        array $details = [],
        string|int|null $user = null,
        DateTimeInterface|null $datetime = null
    ): ScanResult {
        //        dump([ 'meta' => $file->meta() ]);

        return IoCFacade::make(ScanResult::class, [
            'status' => $status,
            'filepath' => $file->uri(),
            'filesize' => (int) $file->getSize(),
            'filename' => $file->filename(),
            'details' => $this->makeScanResultDetails($details),
            'user' => $user ?? $this->user(),
            'datetime' => $datetime
        ]);
    }

    /**
     * Makes scan result details
     *
     * @param  array  $details  [optional]
     *
     * @return array
     */
    protected function makeScanResultDetails(array $details = []): array
    {
        return array_merge([
            'profile' => $this->profile()
        ], $details);
    }
}
