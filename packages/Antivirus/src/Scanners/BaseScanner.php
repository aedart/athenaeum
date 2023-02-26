<?php

namespace Aedart\Antivirus\Scanners;

use Aedart\Antivirus\Exceptions\AntivirusException;
use Aedart\Contracts\Antivirus\Exceptions\AntivirusException as AntivirusExceptionInterface;
use Aedart\Contracts\Antivirus\Results\ScanResult;
use Aedart\Contracts\Antivirus\Scanner;
use Aedart\Contracts\Antivirus\UserResolver;
use Aedart\Contracts\Streams\FileStream;
use Aedart\Contracts\Utils\HasDriverOptions;
use Aedart\Contracts\Utils\HasDriverProfile;
use Aedart\Support\Facades\IoCFacade;
use Aedart\Utils\Concerns\DriverOptions;
use Aedart\Utils\Concerns\DriverProfile;
use Illuminate\Contracts\Events\Dispatcher;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\StreamInterface as PsrStream;
use Psr\Http\Message\UploadedFileInterface;
use Psr\Http\Message\UploadedFileInterface as UploadedFile;
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
abstract class BaseScanner implements
    Scanner,
    HasDriverProfile,
    HasDriverOptions
{
    use DriverProfile;
    use DriverOptions;
    use Concerns\Streams;
    use Concerns\Events;
    use Concerns\Results;
    use Concerns\Status;

    /**
     * The underlying driver for this scanner
     *
     * @var mixed|null
     */
    protected mixed $driver = null;

    /**
     * Creates a new antivirus scanner instance
     *
     * @param Dispatcher|null $dispatcher [optional]
     * @param string|null $profile [optional]
     * @param array $options [optional]
     */
    public function __construct(
        Dispatcher|null $dispatcher = null,
        string|null $profile = null,
        array $options = []
    ) {
        $this
            ->setDispatcher($dispatcher)
            ->setProfile($profile)
            ->setOptions($options);
    }

    /**
     * @inheritDoc
     */
    public function scan(string|SplFileInfo|UploadedFile|FileStream|PsrStream $file): ScanResult
    {
        try {
            // Get Psr stream, in case that uploaded file instance (Psr) is given.
            $file = $file instanceof UploadedFileInterface
                ? $file->getStream()
                : $file;

            // Wrap the file into a stream and scan it.
            $result = $this->scanStream(
                $this->wrapFile($file)
            );

            // If case that a stream was initially given, then we must
            // rewind it, after it was scanned. Underlying "driver"
            // might not do this...
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
    public function isClean(string|SplFileInfo|UploadedFile|FileStream|PsrStream $file): bool
    {
        return $this->scan($file)->isOk();
    }

    /**
     * @inheritDoc
     */
    public function driver(): mixed
    {
        if (isset($this->driver)) {
            return $this->driver;
        }

        return $this->driver = $this->makeDriver();
    }

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
     * Creates a new native driver instance
     *
     * @return mixed
     */
    abstract public function makeDriver(): mixed;

    /*****************************************************************
     * Internals
     ****************************************************************/

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
