<?php

namespace Aedart\Antivirus\Scanners;

use Aedart\Antivirus\Exceptions\AntivirusException;
use Aedart\Antivirus\Scanners\Concerns;
use Aedart\Contracts\Antivirus\Events\FileWasScanned;
use Aedart\Contracts\Antivirus\Exceptions\AntivirusException as AntivirusExceptionInterface;
use Aedart\Contracts\Antivirus\Exceptions\UnsupportedStatusValueException;
use Aedart\Contracts\Antivirus\Results\ScanResult;
use Aedart\Contracts\Antivirus\Results\Status;
use Aedart\Contracts\Antivirus\Scanner;
use Aedart\Contracts\Antivirus\UserResolver;
use Aedart\Contracts\Streams\FileStream;
use Aedart\Support\Facades\IoCFacade;
use Aedart\Support\Helpers\Events\DispatcherTrait;
use DateTimeInterface;
use Illuminate\Contracts\Events\Dispatcher;
use Psr\Http\Message\StreamInterface;
use SplFileInfo;
use Throwable;

/**
 * Base Scanner
 *
 * Abstraction for antivirus scanner
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Antivirus\Scanners
 */
abstract class BaseScanner implements Scanner
{
    use DispatcherTrait;
    use Concerns\Streams;

    /**
     * Creates a new antivirus scanner instance
     *
     * @param Dispatcher|null $dispatcher [optional]
     * @param array $options [optional]
     */
    public function __construct(
        Dispatcher|null $dispatcher = null,
        protected array $options = []
    ) {
        $this->setDispatcher($dispatcher);
    }

    /**
     * @inheritDoc
     */
    public function scan(string|SplFileInfo|FileStream|StreamInterface $file): ScanResult
    {
        try {
            // Wrap the file into a stream and scan it.
            $result = $this->scanStream(
                $this->wrapFile($file)
            );

            // In case provided file is a stream, make sure to rewind
            // it after it has been scanned. Underlying driver might not
            // do this for us.
            if ($file instanceof StreamInterface) {
                $file->rewind();
            }

            // Finally, return the result...
            return $result;
        } catch (AntivirusExceptionInterface $e) {
            throw $e;
        } catch (Throwable $e) {
            throw new AntivirusException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @inheritDoc
     */
    public function isClean(string|SplFileInfo|FileStream|StreamInterface $file): bool
    {
        return $this->scan($file)->isOk();
    }

    /**
     * Get an "item" from this scanner's options
     *
     * @param string|int|array|null $key
     * @param mixed $default [optional]
     *
     * @return mixed
     */
    public function get(string|int|array|null $key, mixed $default = null): mixed
    {
        return data_get($this->options, $key, $default);
    }

    /*****************************************************************
     * Abstract methods
     ****************************************************************/

    /**
     * Performs a virus scan on given file stream
     *
     * @param FileStream $stream
     *
     * @return ScanResult
     *
     * @throws Throwable
     */
    abstract public function scanStream(FileStream $stream): ScanResult;

    /**
     * Return class path to file scan status to be used
     *
     * @return class-string<Status>
     */
    abstract protected function scanStatus(): string;

    /*****************************************************************
     * Internals
     ****************************************************************/

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
    ): ScanResult
    {
        return IoCFacade::make(ScanResult::class, [
            'status' => $status,
            'filename' => $filename,
            'filesize' => $filesize,
            'details' => $details,
            'user' => $user ?? $this->user(),
            'datetime' => $datetime
        ]);
    }

    /**
     * Creates a new file scan status instance
     *
     * @param mixed $value
     * @param string|null $reason [optional]
     *
     * @return Status
     *
     * @throws UnsupportedStatusValueException
     */
    protected function makeScanStatus(mixed $value, string|null $reason = null): Status
    {
        $class = $this->scanStatus();

        return $class::make($value, $reason);
    }

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

    /**
     * Returns the user (identifier) that caused a file scan, if possible
     *
     * @return string|int|null
     */
    protected function user(): string|int|null
    {
        /** @var UserResolver $resolver */
        $resolver = IoCFacade::make(UserResolver::class);

        return $resolver->resolve();
    }
}
