<?php

namespace Aedart\Streams\Concerns;

use Aedart\Contracts\Streams\Stream as StreamInterface;

/**
 * Concerns Hashing
 *
 * @see \Aedart\Contracts\Streams\Hashing\Hashable
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Streams\Concerns
 */
trait Hashing
{
    /**
     * @inheritDoc
     */
    public function hash(
        string $algo,
        bool $binary = false,
        int $flags = 0,
        string $key = '',
        array $options = []
    ): string {
        $msg = 'Unable to compute stream\'s hash';
        $this
            ->assertNotDetached($msg)
            ->assertIsReadable($msg);

        $context = hash_init($algo, $flags, $key, $options);

        $this->restorePositionAfter(function (StreamInterface $stream) use ($context) {
            $stream->rewind();

            hash_update_stream($context, $this->resource());
        });

        return hash_final($context, $binary);
    }
}
