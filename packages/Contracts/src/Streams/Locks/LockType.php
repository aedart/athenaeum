<?php

namespace Aedart\Contracts\Streams\Locks;

/**
 * Lock Type
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Contracts\Streams\Locks
 */
enum LockType: int
{
    /**
     * Shared lock type (reader)
     *
     * Corresponds to PHP's {@see LOCK_SH} lock operation
     *
     * @see https://www.php.net/manual/en/function.flock.php
     */
    case SHARED = 1;

    /**
     * Exclusive lock type (writer)
     *
     * Corresponds to PHP's {@see LOCK_EX} lock operation
     *
     * @see https://www.php.net/manual/en/function.flock.php
     */
    case EXCLUSIVE = 2;

    /**
     * Returns the "operation" (bitmask) equivalent value of this lock type
     *
     * @see LOCK_SH
     * @see LOCK_EX
     * @see https://www.php.net/manual/en/function.flock.php
     *
     * @return int
     */
    public function operation(): int
    {
        return match($this) {
            LockType::SHARED => LOCK_SH,
            LockType::EXCLUSIVE => LOCK_EX,
        };
    }
}
