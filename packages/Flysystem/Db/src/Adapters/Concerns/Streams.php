<?php

namespace Aedart\Flysystem\Db\Adapters\Concerns;

use Aedart\Contracts\Streams\Exceptions\StreamException;
use Aedart\Contracts\Streams\FileStream as FileStreamInterface;
use Aedart\Streams\FileStream;

/**
 * Concerns Streams
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Flysystem\Db\Adapters\Concerns
 */
trait Streams
{
    /**
     * Creates a new in-memory file stream
     *
     * @return FileStreamInterface
     *
     * @throws StreamException
     */
    protected function openMemoryStream(): FileStreamInterface
    {
        return FileStream::openMemory('r+b');
    }
}