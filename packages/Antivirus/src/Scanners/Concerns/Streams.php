<?php

namespace Aedart\Antivirus\Scanners\Concerns;

use Aedart\Antivirus\Exceptions\UnableToOpenFileStream;
use Aedart\Contracts\Antivirus\Exceptions\AntivirusException;
use Aedart\Contracts\Streams\BufferSizes;
use Aedart\Contracts\Streams\FileStream as FileStreamInterface;
use Aedart\Streams\FileStream;
use Psr\Http\Message\StreamInterface as PsrStreamInterface;
use Psr\Http\Message\UploadedFileInterface;
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
     * Set maximum amount of bytes to keep in memory before writing to a temporary file.
     *
     * Applicable only when dealing with Psr Streams!
     *
     * @param  int|null  $bytes
     *
     * @return static
     */
    public function setStreamMaxMemory(int|null $bytes): static
    {
        return $this->set('temporary_stream_max_memory', $bytes);
    }

    /**
     * Get maximum amount of bytes to keep in memory before writing to a temporary file.
     *
     * Applicable only when dealing with Psr Streams!
     *
     * @return int Defaults to 2 Mb if no value was set
     */
    public function getStreamMaxMemory(): int
    {
        return $this->get('temporary_stream_max_memory', BufferSizes::BUFFER_1MB * 2);
    }

    /**
     * Set amount of bytes to read from stream
     *
     * @param  int|null  $bytes
     *
     * @return static
     */
    public function setStreamBufferSize(int|null $bytes): static
    {
        return $this->set('stream_buffer_size', $bytes);
    }

    /**
     * Get amount of bytes to read from stream
     *
     * @return int Defaults to 2 Mb if no value was set
     */
    public function getStreamBufferSize(): int
    {
        return $this->get('stream_buffer_size', BufferSizes::BUFFER_1MB * 2);
    }

    /**
     * Wraps given file into a file stream
     *
     * @param  string|SplFileInfo|UploadedFileInterface|FileStreamInterface|PsrStreamInterface  $file
     *
     * @return FileStreamInterface
     *
     * @throws AntivirusException
     */
    protected function wrapFile(string|SplFileInfo|UploadedFileInterface|FileStreamInterface|PsrStreamInterface $file
    ): FileStreamInterface {
        return match (true) {
            is_string($file) => $this->openStreamForPath($file),
            $file instanceof SplFileInfo => $this->openStreamForFileInfo($file),
            $file instanceof FileStreamInterface => $this->wrapStream($file),

            // When a Psr stream is given it must be copied, or we risk that it
            // might get detached and prevent further operations on it, outside
            // the scope of an antivirus scanner!
            $file instanceof PsrStreamInterface => $this->copyPsrStream($file),
            $file instanceof UploadedFileInterface => $this->copyPsrStream($file->getStream()),
        };
    }

    /**
     * Open a stream for given file path
     *
     * @param  string  $path
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
            throw new UnableToOpenFileStream(sprintf(
                'Unable to open stream for file path %s',
                $path
            ), $e->getCode(), $e);
        }
    }

    /**
     * Open a stream for given Spl File Info instance
     *
     * @param  SplFileInfo  $file
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
     * @param  FileStreamInterface  $stream
     * @param  bool  $rewind  [optional]
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
     * Copies given PSR-7 stream into a new temporary stream
     *
     * @param  PsrStreamInterface  $stream  Psr stream
     * @param  bool  $rewind  [optional]
     *
     * @return FileStreamInterface
     *
     * @throws AntivirusException
     */
    protected function copyPsrStream(PsrStreamInterface $stream, bool $rewind = true): FileStreamInterface
    {
        try {
            $copy = FileStream::openTemporary(maximumMemory: $this->getStreamMaxMemory())
                ->copyFrom(source: $stream, bufferSize: $this->getStreamBufferSize());

            if ($rewind) {
                $stream->rewind();
                $copy->positionToStart();
            }

            return $copy;
        } catch (Throwable $e) {
            throw new UnableToOpenFileStream($e->getMessage(), $e->getCode(), $e);
        }
    }
}
