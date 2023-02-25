<?php

namespace Aedart\Streams\Concerns;

use Aedart\Contracts\Streams\BufferSizes;
use Aedart\Contracts\Streams\Stream as StreamInterface;
use Aedart\Streams\Exceptions\CannotCopyToTargetStream;
use Aedart\Streams\Exceptions\StreamException;
use Psr\Http\Message\StreamInterface as PsrStreamInterface;

/**
 * Concerns Copying
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Streams\Concerns
 */
trait Copying
{
    /**
     * Perform copy of source stream into given target stream
     *
     * @param  StreamInterface  $source The source to copy from
     * @param  StreamInterface  $target The target stream to copy to
     * @param  int|null  $length  [optional] Maximum bytes to copy from source stream. By default, all bytes left are copied
     * @param  int  $offset  [optional] The offset on source stream where to start to copy data from
     *
     * @return int Bytes copied
     *
     * @throws StreamException
     */
    protected function copySourceToTarget(StreamInterface $source, StreamInterface $target, int|null $length = null, int $offset = 0): int
    {
        // Abort if source is detached or not readable
        if ($source->isDetached() || !$source->isReadable()) {
            throw new CannotCopyToTargetStream('Source stream is either detached or not readable.');
        }

        // Abort if target is not writable or detached
        if ($target->isDetached() || !$target->isWritable()) {
            throw new CannotCopyToTargetStream('Target stream is either detached or not writable.');
        }

        return $this->copyRawResource(
            $source->resource(),
            $target->resource(),
            $length,
            $offset
        );
    }

    /**
     * Copies data from a {@see PsrStreamInterface} stream to given target stream
     *
     * @param  PsrStreamInterface  $source PSR stream to copy from
     * @param  StreamInterface  $target The target stream to copy to
     * @param  int|null  $length  [optional] Maximum bytes to copy from source stream. By default, all bytes left are copied
     * @param  int  $offset  [optional] The offset on source stream where to start to copy data from
     * @param  int  $bufferSize  [optional] Read/Write size of each chunk in bytes.
     *
     * @return int Bytes copied
     *
     * @throws StreamException
     */
    protected function copyFromPsrStream(
        PsrStreamInterface $source,
        StreamInterface $target,
        int|null $length = null,
        int $offset = 0,
        int $bufferSize = BufferSizes::BUFFER_8KB
    ): int
    {
        // Abort if source is not readable or seekable
        if (!$source->isReadable() || !$source->isSeekable()) {
            throw new CannotCopyToTargetStream('Source stream is either not readable or seekable.');
        }

        // Abort if target is not writable or detached
        if ($target->isDetached() || !$target->isWritable()) {
            throw new CannotCopyToTargetStream('Target stream is either detached or not writable.');
        }

        // Abort in case that source's size cannot be determined.
        $sourceSize = (int) $source->getSize();
        if ($sourceSize === 0) {
            throw new CannotCopyToTargetStream('Unable to read size of source stream.');
        }

        // Seek position in source stream
        $source->seek($offset);

        // Resolve the read length. Whenever it is less than the buffer size,
        // just read and write the data.
        $length = $length ?? $sourceSize - $source->tell();
        if ($length <= $bufferSize && !$source->eof()) {
            return $target->write($source->read($length));
        }

        // Otherwise, since we cannot use PHP's stream_copy_to_stream, we need to manually
        // and carefully buffer read and write from the source to the target. This must be
        // done so, in case that a very large Psr stream is copied.
        $writtenBytes = 0;
        $end = $offset + $length - 1;
        $readLength = $bufferSize;

        while (!$source->eof() && ($position = $source->tell()) <= $end) {
            // Prevent out-of-bounds issues
            if ($position + $bufferSize > $end) {
                $readLength = $end - $position + 1;
            }

            // Copy chunk...
            $writtenBytes += $target->write(
                $source->read($readLength)
            );
        }

        return $writtenBytes;
    }

    /**
     * Copy from a source resource to a target resource
     *
     * @see https://www.php.net/manual/en/function.stream-copy-to-stream
     *
     * @param  resource $source The source resource to copy from
     * @param  resource $target The target resource to copy to
     * @param  int|null  $length  [optional] Maximum bytes to copy from source stream. By default, all bytes left are copied
     * @param  int  $offset  [optional] The offset on source stream where to start to copy data from
     *
     * @return int Bytes copied
     *
     * @throws StreamException
     */
    protected function copyRawResource($source, $target, int|null $length = null, int $offset = 0): int
    {
        $bytesCopied = stream_copy_to_stream(
            from: $source,
            to: $target,
            length: $length,
            offset: $offset
        );

        if ($bytesCopied === false) {
            throw new StreamException('Copy operation failed. Streams might be blocked, incorrect length, offset, or otherwise invalid');
        }

        return $bytesCopied;
    }
}
