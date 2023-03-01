<?php

namespace Aedart\Antivirus\Events;

use Aedart\Contracts\Antivirus\Events\FileWasScanned as FileWasScannedInterface;
use Aedart\Contracts\Antivirus\Results\ScanResult;

/**
 * File Was Scanned Event
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Antivirus\Events
 */
class FileWasScanned implements FileWasScannedInterface
{
    /**
     * Create a new event instance
     *
     * @param ScanResult $result
     */
    public function __construct(
        protected ScanResult $result
    ) {
    }

    /**
     * @inheritDoc
     */
    public function result(): ScanResult
    {
        return $this->result;
    }
}
