<?php

namespace Aedart\Contracts\Streams;

use Aedart\Contracts\Streams\Exceptions\LockException;
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
     * Shared lock type (reader)
     *
     * Corresponds to PHP's {@see LOCK_SH} lock operation
     *
     * @see https://www.php.net/manual/en/function.flock.php
     */
    public const SHARED = 1;

    /**
     * Exclusive lock type (writer)
     *
     * Corresponds to PHP's {@see LOCK_EX} lock operation
     *
     * @see https://www.php.net/manual/en/function.flock.php
     */
    public const EXCLUSIVE = 2;

    /**
     * Acquire lock on stream
     *
     * Method attempts to acquire a lock on stream or fails if unable to.
     *
     * @param  int  $type  [optional] {@see EXCLUSIVE} exclusive lock (writer) or {@see SHARED} shared lock (reader)
     * @param  int  $timeout  [optional] Timeout in microseconds. 1 second = 1.000.000 microseconds
     *
     * @return bool
     *
     * @throws LockException If unable to acquire lock
     * @throws InvalidArgumentException If `$type` or `$timeout` are invalid
     */
    public function acquire(int $type = self::EXCLUSIVE, int $timeout = 500_000): bool;

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
