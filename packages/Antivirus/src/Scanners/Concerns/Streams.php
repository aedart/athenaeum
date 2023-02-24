<?php

namespace Aedart\Antivirus\Scanners\Concerns;

use Aedart\Antivirus\Exceptions\UnableToOpenFileStream;
use Aedart\Contracts\Antivirus\Exceptions\AntivirusException;
use Aedart\Contracts\Streams\FileStream as FileStreamInterface;
use Aedart\Streams\FileStream;
use Psr\Http\Message\StreamInterface;
use SplFileInfo;
use Throwable;

/**
 * Concern Streams
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Antivirus\Scanners\Concerns
 */
trait Streams
{
    /**
     * Wraps given file into a file stream
     *
     * @param string|SplFileInfo|FileStreamInterface|StreamInterface $file
     *
     * @return FileStreamInterface
     *
     * @throws AntivirusException
     */
    protected function wrapFile(string|SplFileInfo|FileStreamInterface|StreamInterface $file): FileStreamInterface
    {
        return match (true) {
            is_string($file) => $this->openStreamForPath($file),
            $file instanceof SplFileInfo => $this->openStreamForFileInfo($file),
            $file instanceof FileStreamInterface => $this->wrapStream($file),

            // When a Psr stream is given it must be copied, or we risk that it
            // might get detached and prevent further operations on it, outside
            // the scope of an antivirus scanner!
            $file instanceof StreamInterface => $this->copyStream($file)
        };
    }

    /**
     * Open a stream for given file path
     *
     * @param string $path
     *
     * @return FileStreamInterface
     *
     * @throws AntivirusException
     */
    protected function openStreamForPath(string $path): FileStreamInterface
    {
        try {
            return FileStream::open($path, 'r');
        } catch (Throwable $e) {
            throw new UnableToOpenFileStream(sprintf('Unable to open stream for file path %s', $path), $e->getCode(), $e);
        }
    }

    /**
     * Open a stream for given Spl File Info instance
     *
     * @param SplFileInfo $file
     *
     * @return FileStreamInterface
     *
     * @throws AntivirusException
     */
    protected function openStreamForFileInfo(SplFileInfo $file): FileStreamInterface
    {
        $path = $file->getRealPath();
        if ($path === false) {
            throw new UnableToOpenFileStream(sprintf('File %s does not exist', $file->getFilename()));
        }

        return $this->openStreamForPath($path);
    }

    /**
     * Wrap stream
     *
     * @param FileStreamInterface $stream
     * @param bool $rewind [optional]
     *
     * @return FileStreamInterface
     *
     * @throws AntivirusException
     */
    protected function wrapStream(FileStreamInterface $stream, bool $rewind = true): FileStreamInterface
    {
        try {
            if ($rewind) {
                $stream->rewind();
            }

            return $stream;
        } catch (Throwable $e) {
            throw new UnableToOpenFileStream($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Copies given stream
     *
     * @param StreamInterface $stream Psr stream
     *
     * @return FileStreamInterface
     *
     * @throws AntivirusException
     */
    protected function copyStream(StreamInterface $stream): FileStreamInterface
    {
        try {
            $stream->rewind();

            $copy = FileStream::openTemporary()
                ->put($stream->getContents())
                ->positionToStart();

            $stream->rewind();

            return $copy;
        } catch (Throwable $e) {
            throw new UnableToOpenFileStream($e->getMessage(), $e->getCode(), $e);
        }
    }
}
