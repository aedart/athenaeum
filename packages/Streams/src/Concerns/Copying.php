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
     * Perform copy of source stream into given target stream
     *
     * @param  StreamInterface  $source The source to copy from
     * @param  StreamInterface  $target The target to copy to
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
        if ($source->isDetached() || !$target->isReadable()) {
            throw new CannotCopyToTargetStream('Source stream is either detached or not readable.');
        }

        // Abort if target is not writable or detached
        if ($target->isDetached() || !$target->isWritable()) {
            throw new CannotCopyToTargetStream('Target stream is either detached or not writable.');
        }

        return $this->copyResourceTo(
            $source->resource(),
            $target->resource(),
            $length,
            $offset
        );
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
    protected function copyResourceTo($source, $target, int|null $length = null, int $offset = 0): int
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
