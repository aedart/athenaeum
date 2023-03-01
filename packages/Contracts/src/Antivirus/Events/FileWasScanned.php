<?php

namespace Aedart\Contracts\Antivirus\Events;

use Aedart\Contracts\Antivirus\Results\ScanResult;

/**
 * File Was Scanned
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Antivirus\Events
 */
interface FileWasScanned
{
    /**
     * Returns the antivirus scan result
     *
     * @return ScanResult
     */
    public function result(): ScanResult;
}
