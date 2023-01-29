<?php

namespace Aedart\Flysystem\Db\Adapters\Concerns;

use Aedart\Contracts\Streams\BufferSizes;
use Aedart\Contracts\Streams\Exceptions\StreamException;
use Aedart\Contracts\Streams\FileStream as FileStreamInterface;
use Aedart\Streams\FileStream;
use League\Flysystem\Config;

/**
 * Concerns Streams
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Flysystem\Db\Adapters\Concerns
 */
trait Streams
{
    /**
     * Default maximum amount of bytes to keep in
     * memory before writing to a temporary file.
     *
     * @see FileStreamInterface::openTemporary
     *
     * @var float|int
     */
    protected float|int $defaultMaxMemory = 2 * BufferSizes::BUFFER_1MB;

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

    /**
     * Open a stream to 'php://temp' and wrap the resource into a new stream instance
     *
     * @param int|null $maxMemory [optional]
     *
     * @return FileStreamInterface
     *
     * @throws StreamException
     */
    protected function openTemporaryStream(int|null $maxMemory = null): FileStreamInterface
    {
        return FileStream::openTemporary('r+b', $maxMemory);
    }

    /**
     * Wrap given stream resource into a File Stream instance
     *
     * @param resource $resource
     *
     * @return FileStreamInterface
     *
     * @throws StreamException
     */
    protected function openStreamFrom($resource): FileStreamInterface
    {
        return FileStream::make($resource);
    }

    /**
     * Resolve maximum amount of bytes to keep in memory before
     * writing to a temporary file.
     *
     * If no "max_memory" entry is specified in given config, then a default
     * value is returned.
     *
     * @param Config|null $config [optional]
     *
     * @return int Bytes
     */
    protected function resolveMaxMemory(Config|null $config = null): int
    {
        if (!isset($config)) {
            return $this->defaultMaxMemory;
        }

        return $config->get('max_memory', $this->defaultMaxMemory);
    }
}
