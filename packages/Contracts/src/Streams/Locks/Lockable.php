<?php

namespace Aedart\Contracts\Streams\Locks;

use Aedart\Contracts\Streams\Stream;
use Throwable;

/**
 * Lockable
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Streams\Locks
 */
interface Lockable extends LockFactoryAware
{
    /**
     * Locks stream and performs given operation.
     *
     * Method attempts to acquire a lock before invoking given operation
     * callback. Upon completion of operation, the lock is automatically
     * released.
     *
     * In case that the operation callback fails (exception is thrown), then
     * lock will automatically be released, before re-throwing the
     * exception.
     *
     * **Caution**: _Fails if stream does not support locking. Use {@see Stream::supportsLocking()}
     * to determine if stream can be locked._
     *
     * **Block mode**: _Stream's blocking or non-blocking mode is NOT set by this method!_
     *
     * @see \Aedart\Contracts\Streams\Locks\Lock
     * @see Stream::supportsLocking()
     *
     * @param  callable(Stream $stream, Lock $lock): mixed  $operation Callback to invoke.
     *                                                      This stream instance and acquired lock are given
     *                                                      as callback arguments.
     * @param  int  $type  [optional] The type of lock. {@see LockTypes::EXCLUSIVE} lock (writer) or {@see LockTypes::SHARED} lock (reader).
     * @param  float  $timeout  [optional] Timeout of acquiring lock in seconds.
     * @param  string|null  $profile  [optional] Lock profile driver to use. If `null`, then a default driver is used.
     * @param  array  $options  [optional] Lock driver specific options
     *
     * @return mixed Callback return value, if any
     *
     * @throws Throwable
     */
    public function lock(
        callable $operation,
        int $type = LockTypes::EXCLUSIVE,
        float $timeout = 0.5,
        string|null $profile = null,
        array $options = []
    ): mixed;

    /**
     * Locks stream and performs given operation, using {@see LockTypes::EXCLUSIVE}
     *
     * Method is a shortcut for invoking {@see lock()} with exclusive lock type.
     *
     * @see lock()
     *
     * @param  callable(Stream $stream, Lock $lock): mixed  $operation
     * @param  float  $timeout  [optional]
     * @param  string|null  $profile  [optional]
     * @param  array  $options  [optional]
     *
     * @return mixed
     *
     * @throws Throwable
     */
    public function exclusiveLock(
        callable $operation,
        float $timeout = 0.5,
        string|null $profile = null,
        array $options = []
    ): mixed;

    /**
     * Locks stream and performs given operation, using {@see LockTypes::SHARED}
     *
     * Method is a shortcut for invoking {@see lock()} with shared lock type.
     *
     * @see lock()
     *
     * @param  callable(Stream $stream, Lock $lock): mixed  $operation
     * @param  float  $timeout  [optional]
     * @param  string|null  $profile  [optional]
     * @param  array  $options  [optional]
     *
     * @return mixed
     *
     * @throws Throwable
     */
    public function sharedLock(
        callable $operation,
        float $timeout = 0.5,
        string|null $profile = null,
        array $options = []
    ): mixed;
}
