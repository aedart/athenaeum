<?php

namespace Aedart\Contracts\Antivirus;

use Aedart\Contracts\Antivirus\Events\FileWasScanned;
use Aedart\Contracts\Antivirus\Exceptions\AntivirusException;
use Aedart\Contracts\Antivirus\Results\ScanResult;
use Aedart\Contracts\Streams\FileStream;
use Aedart\Contracts\Support\Helpers\Events\DispatcherAware;
use Psr\Http\Message\StreamInterface;
use SplFileInfo;

/**
 * Antivirus Scanner
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Antivirus
 */
interface Scanner extends DispatcherAware
{
    /**
     * Scan a single file for infections
     *
     * Upon completion, this method dispatches a {@see FileWasScanned} event.
     *
     * @param string|SplFileInfo|FileStream|StreamInterface $file Path to file, file object, or
     *                                                      a stream of the file.
     *
     * @return ScanResult
     *
     * @throws AntivirusException
     */
    public function scan(string|SplFileInfo|FileStream|StreamInterface $file): ScanResult;

    /**
     * Determine if file is clean
     *
     * Method scans the file and returns true only if file does not contain
     * infections and no scanning errors occurred.
     *
     * @param string|SplFileInfo|FileStream|StreamInterface $file Path to file, file object, or
     *                                                      a stream of the file.
     *
     * @return bool
     *
     * @throws AntivirusException
     */
    public function isClean(string|SplFileInfo|FileStream|StreamInterface $file): bool;

    /**
     * Returns the native driver used by this scanner
     *
     * @return mixed
     */
    public function driver(): mixed;
}
