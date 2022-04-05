<?php

namespace Aedart\Streams\Concerns;

use Aedart\Contracts\Streams\Stream as StreamInterface;
use Aedart\Streams\Exceptions\CannotCopyToTargetStream;
use Aedart\Streams\Exceptions\StreamException;

/**
 * Concerns Copying
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Streams\Concerns
 */
trait Copying
{
    /**
     * Perform copy of this stream into given target
     *
     * @param  StreamInterface  $source The source to copy from
     * @param  StreamInterface  $target The target to copy to
     * @param  int|null  $length  [optional]
     * @param  int  $offset  [optional]
     *
     * @return int Bytes copied
     *
     * @throws StreamException
     */
    protected function performCopy(StreamInterface $source, StreamInterface $target, int|null $length = null, int $offset = 0): int
    {
        // Abort if source is detached or not readable
        if ($source->isDetached() || !$target->isReadable()) {
            throw new CannotCopyToTargetStream('Source stream is either detached or not readable.');
        }

        // Abort if target is not writable or detached
        if ($target->isDetached() || !$target->isWritable()) {
            throw new CannotCopyToTargetStream('Target stream is either detached or not writable.');
        }

        $bytesCopied = stream_copy_to_stream(
            $source->resource(),
            $target->resource(),
            $length,
            $offset
        );

        if ($bytesCopied === false) {
            throw new StreamException('Copy operation failed. Streams might be blocked or otherwise invalid, or "length" and "offset" are invalid');
        }

        return $bytesCopied;
    }
}
