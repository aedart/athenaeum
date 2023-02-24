<?php

namespace Aedart\Antivirus\Scanners;

use Aedart\Contracts\Antivirus\Results\ScanResult;
use Aedart\Contracts\Antivirus\Scanner;
use Aedart\Contracts\Streams\FileStream;
use Aedart\Support\Helpers\Events\DispatcherTrait;
use Psr\Http\Message\StreamInterface;
use SplFileInfo;

/**
 * Base Scanner
 *
 * Abstraction for antivirus scanner
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Antivirus\Scanners
 */
abstract class BaseScanner implements Scanner
{
    use DispatcherTrait;

    /**
     * @inheritDoc
     */
    public function scan(string|SplFileInfo|FileStream|StreamInterface $file): ScanResult
    {
        // TODO: Add a default try-catch implementation that invokes a "scanFile" method...
    }

    /**
     * @inheritDoc
     */
    public function isClean(string|SplFileInfo|FileStream|StreamInterface $file): bool
    {
        return $this->scan($file)->isOk();
    }
}