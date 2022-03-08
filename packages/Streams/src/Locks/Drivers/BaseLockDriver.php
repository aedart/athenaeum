<?php

namespace Aedart\Streams\Locks\Drivers;

use Aedart\Contracts\Streams\Exceptions\StreamException;
use Aedart\Contracts\Streams\Locks\Lock;
use Aedart\Contracts\Streams\Locks\LockTypes;
use Aedart\Contracts\Streams\Stream;
use Aedart\Streams\Exceptions\Locks\LockFailure;
use Aedart\Streams\Exceptions\Locks\LockReleaseFailure;
use Aedart\Streams\Exceptions\Locks\StreamCannotBeLocked;
use Aedart\Utils\Arr;
use Throwable;

/**
 * Base Lock Driver
 *
 * Abstraction for lock drivers
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Streams\Locks\Drivers
 */
abstract class BaseLockDriver implements Lock
{
    /**
     * Acquired state
     *
     * @var bool
     */
    protected bool $isAcquired = false;

    /**
     * Creates new lock driver instance
     *
     * @param  Stream  $stream The stream to be locked
     * @param  array  $options  [optional]
     */
    public function __construct(
        protected Stream $stream,
        protected array $options = []
    )
    {}

    /**
     * Acquire lock
     *
     * @param  Stream  $stream
     * @param  int  $type  {@see LockTypes::EXCLUSIVE} lock (writer) or {@see LockTypes::SHARED} lock (reader)
     * @param  int  $timeout  Timeout in microseconds. 1 second = 1.000.000 microseconds
     *
     * @return bool
     *
     * @throws Throwable
     */
    abstract public function acquireLock(Stream $stream, int $type, int $timeout): bool;

    /**
     * Release lock
     *
     * @param  Stream  $stream
     *
     * @return void
     *
     * @throws Throwable
     */
    abstract public function releaseLock(Stream $stream): void;

    /**
     * @inheritDoc
     *
     * @throws StreamException
     */
    public function acquire(int $type = LockTypes::EXCLUSIVE, int $timeout = 500_000): bool
    {
        if (!$this->streamSupportsLocking()) {
            throw new StreamCannotBeLocked('Stream does not support locking');
        }

        if ($this->isAcquired()) {
            throw new StreamCannotBeLocked('Stream is already locked');
        }

        try {
            $acquired = $this->acquireLock($this->getStream(), $type, $timeout);

            if ($acquired) {
                $this->setAcquired(true);
                return true;
            }

            return false;
        } catch (Throwable $e) {
            throw new LockFailure($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @inheritDoc
     */
    public function release(): void
    {
        // Skip if already released
        if ($this->isReleased()) {
            return;
        }

        try {
            $this->releaseLock($this->getStream());

            $this->setAcquired(false);
        } catch (Throwable $e) {
            throw new LockReleaseFailure($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @inheritDoc
     */
    public function isAcquired(): bool
    {
        return $this->isAcquired;
    }

    /**
     * @inheritDoc
     */
    public function isReleased(): bool
    {
        return !$this->isAcquired();
    }

    /**
     * @inheritDoc
     */
    public function getStream(): Stream
    {
        return $this->stream;
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Set acquired state
     *
     * @param  bool  $isAcquired
     *
     * @return self
     */
    protected function setAcquired(bool $isAcquired): static
    {
        $this->isAcquired = $isAcquired;

        return $this;
    }

    /**
     * Determine if stream supports locking
     *
     * @return bool
     *
     * @throws StreamException
     */
    protected function streamSupportsLocking(): bool
    {
        return $this->getStream()->supportsLocking();
    }

    /**
     * Get option value
     *
     * @param  string  $key
     * @param  mixed|null  $default  [optional]
     *
     * @return mixed
     */
    protected function get(string $key, mixed $default = null): mixed
    {
        return Arr::get($this->options, $key, $default);
    }
}