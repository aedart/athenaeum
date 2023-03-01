<?php

namespace Aedart\Streams\Concerns;

use Aedart\Contracts\Streams\BufferSizes;
use Aedart\Streams\Exceptions\StreamException;
use Aedart\Streams\Exceptions\StreamNotReadable;
use Aedart\Streams\Exceptions\StreamNotSeekable;
use Psr\Http\Message\StreamInterface as PsrStreamInterface;

/**
 * Concerns Buffering
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Streams\Concerns
 */
trait Buffering
{
    /**
     * Read stream in chunks of specified buffer size
     *
     * @param  PsrStreamInterface  $source The stream to read from.
     * @param  int|null  $length  [optional] Maximum bytes to read from stream. By default, all bytes left are read.
     * @param  int  $offset  [optional] The offset on where to start to reading from.
     * @param  int  $bufferSize  [optional] Read buffer size of each chunk in bytes.
     *
     * @return iterable<string>
     */
    protected function bufferStream(
        PsrStreamInterface $source,
        int|null $length = null,
        int $offset = 0,
        int $bufferSize = BufferSizes::BUFFER_8KB
    ): iterable {
        // Abort if not readable or seekable
        if (!$source->isReadable()) {
            throw new StreamNotReadable('Source stream is not readable.');
        }
        if (!$source->isSeekable()) {
            throw new StreamNotSeekable('Source stream is not seekable.');
        }

        // Abort in case that source's size cannot be determined.
        $size = (int) $source->getSize();
        if ($size === 0) {
            throw new StreamException('Unable to read size of source stream.');
        }

        // Seek position in source stream
        $source->seek($offset);

        // Resolve the read length. Whenever it is less than the buffer size,
        // just read and write the data.
        $length = $length ?? $size - $source->tell();
        if ($length <= $bufferSize && !$source->eof()) {
            yield $source->read($length);
        }

        // Read the remaining of the stream in chunks of the specified buffer size.
        $end = $offset + $length - 1;
        $readLength = $bufferSize;

        while (!$source->eof() && ($position = $source->tell()) <= $end) {
            // Prevent out-of-bounds issues
            if ($position + $bufferSize > $end) {
                $readLength = $end - $position + 1;
            }

            // Read chunk...
            yield $source->read($readLength);
        }
    }
}
