<?php

namespace Aedart\Contracts\Streams\Locks;

/**
 * Lock Types
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Streams\Locks
 */
interface LockTypes
{
    /**
     * Shared lock type (reader)
     *
     * Corresponds to PHP's {@see LOCK_SH} lock operation
     *
     * @see https://www.php.net/manual/en/function.flock.php
     */
    public const int SHARED = 1;

    /**
     * Exclusive lock type (writer)
     *
     * Corresponds to PHP's {@see LOCK_EX} lock operation
     *
     * @see https://www.php.net/manual/en/function.flock.php
     */
    public const int EXCLUSIVE = 2;
}
