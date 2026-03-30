<?php

namespace Aedart\Streams\Locks\Drivers;

use Aedart\Contracts\Streams\Exceptions\StreamException;
use Aedart\Contracts\Streams\Locks\Lock;
use Aedart\Contracts\Streams\Locks\LockType;
use Aedart\Contracts\Streams\Stream;
use Aedart\Streams\Exceptions\Locks\LockFailure;
use Aedart\Streams\Exceptions\Locks\LockReleaseFailure;
use Aedart\Streams\Exceptions\Locks\StreamCannotBeLocked;
use Aedart\Utils\Arr;
use InvalidArgumentException;
use RuntimeException;
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
    ) {
    }

    /**
     * Destructor
     *
     * @throws \Aedart\Contracts\Streams\Exceptions\LockException
     */
    public function __destruct()
    {
        $this->release();
    }

    /**
     * Acquire lock
     *
     * @param  Stream  $stream
     * @param  LockType  $type
     * @param  float  $timeout  Timeout in seconds.
     *
     * @return bool
     *
     * @throws Throwable
     */
    abstract public function acquireLock(Stream $stream, LockType $type, float $timeout): bool;

    /**
     * Release lock
     *
     * @param  Stream  $stream
     *
     * @return bool
     *
     * @throws Throwable
     */
    abstract public function releaseLock(Stream $stream): bool;

    /**
     * @inheritDoc
     *
     * @throws StreamException
     */
    public function acquire(int|LockType $type = LockType::EXCLUSIVE, float $timeout = 0.5): bool
    {
        // Skip if already acquired
        if ($this->isAcquired()) {
            return true;
        }

        if (!$this->streamSupportsLocking()) {
            throw new StreamCannotBeLocked('Stream does not support locking');
        }

        if ($timeout < 0) {
            throw new InvalidArgumentException(sprintf('Timeout to acquire lock cannot be negative. %d given', $timeout));
        }

        try {
            $type = is_int($type)
                ? $type::from($type)
                : $type;

            $acquired = $this->acquireLock($this->getStream(), $type, $timeout);

            $this->setAcquired($acquired);

            return $acquired;
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

        // Skip if stream has been detached
        $stream = $this->getStream();
        if ($stream->isDetached()) {
            $this->setAcquired(false);
            return;
        }

        // Attempt release lock...
        try {
            $released = $this->releaseLock($stream);

            $this->setAcquired(!$released);

            if (!$released) {
                throw new RuntimeException('Failed to release lock');
            }
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
