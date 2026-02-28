<?php

namespace Aedart\Contracts\Streams\Locks;

use Aedart\Contracts\Streams\Exceptions\LockException;
use Aedart\Contracts\Streams\Stream;
use InvalidArgumentException;

/**
 * Stream Lock
 *
 * Inspired by Symfony's Lock Interface
 * @see https://github.com/symfony/lock/blob/5.4/LockInterface.php
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Streams
 */
interface Lock
{
    /**
     * Acquire lock on stream
     *
     * Method attempts to acquire a lock on stream or fails if unable to.
     *
     * @param  int|LockType  $type  [optional]
     * @param  float  $timeout  [optional] Timeout in seconds.
     *
     * @return bool
     *
     * @throws LockException If unable to acquire lock
     * @throws InvalidArgumentException If `$type` or `$timeout` are invalid
     */
    public function acquire(int|LockType $type = LockType::EXCLUSIVE, float $timeout = 0.5): bool;

    /**
     * Release the lock
     *
     * @return void
     *
     * @throws LockException If unable to release
     */
    public function release(): void;

    /**
     * Determine if lock is acquired
     *
     * @return bool
     */
    public function isAcquired(): bool;

    /**
     * Determine if lock is released
     *
     * @return bool
     */
    public function isReleased(): bool;

    /**
     * Get the stream this lock is for
     *
     * @return Stream
     */
    public function getStream(): Stream;
}
