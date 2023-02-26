<?php

namespace Aedart\Antivirus\Scanners\Concerns;

use Aedart\Contracts\Antivirus\Events\FileWasScanned;
use Aedart\Contracts\Antivirus\Results\ScanResult;
use Aedart\Support\Facades\IoCFacade;
use Aedart\Support\Helpers\Events\DispatcherTrait;

/**
 * Concerns Events
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Antivirus\Scanners\Concerns
 */
trait Events
{
    use DispatcherTrait;

    /**
     * Dispatches "file was scanned" event with given scan result
     *
     * @param ScanResult $result
     *
     * @return void
     */
    protected function dispatchFileWasScanned(ScanResult $result): void
    {
        $event = $this->makeFileWasScannedEvent($result);

        $this->getDispatcher()->dispatch(FileWasScanned::class, $event);
    }

    /**
     * Creates a new "file was scanned" event instance
     *
     * @param ScanResult $result
     *
     * @return FileWasScanned
     */
    protected function makeFileWasScannedEvent(ScanResult $result): FileWasScanned
    {
        return IoCFacade::make(FileWasScanned::class, [ 'result' => $result ]);
    }
}
