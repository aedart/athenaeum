<?php

namespace Aedart\Antivirus\Scanners;

use Aedart\Antivirus\Scanners\Status\GenericStatus;
use Aedart\Contracts\Antivirus\Results\ScanResult;
use Aedart\Contracts\Streams\FileStream;

/**
 * Null Scanner
 *
 * Intended for testing or situation when a scanner is
 * required, yet not intended to do anything.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Antivirus\Scanners
 */
class NullScanner extends BaseScanner
{
    /**
     * @inheritDoc
     */
    public function scanStream(FileStream $stream): ScanResult
    {
        return $this->makeScanResult(
            status: $this->makeScanStatus(
                $this->shouldPass(),
                'File was not actually scanned (Null scanner)'
            ),
            filename: $stream->uri(),
            filesize: (int) $stream->getSize(),
        );
    }

    /**
     * @inheritDoc
     */
    protected function statusClass(): string
    {
        return GenericStatus::class;
    }

    /**
     * @inheritDoc
     */
    public function driver(): mixed
    {
        return null;
    }

    /**
     * Determine if scanner should pass file scans, or fail them
     *
     * @return bool
     */
    public function shouldPass(): bool
    {
        return $this->get('should_pass', false);
    }
}
