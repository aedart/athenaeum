<?php

namespace Aedart\Contracts\Streams\Locks;

/**
 * Lock Types
 *
 * @deprecated Replaced by {@see \Aedart\Contracts\Streams\Locks\LockType}, since v10.x
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Streams\Locks
 */
interface LockTypes
{
    /**
     * Shared lock type (reader)
     *
     * @deprecated use {@see \Aedart\Contracts\Streams\Locks\LockType::SHARED} instead, since v10.x
     */
    #[\Deprecated(message: "use \Aedart\Contracts\Streams\Locks\LockType::SHARED instead", since: "10.x")]
    public const int SHARED = 1;

    /**
     * Exclusive lock type (writer)
     *
     * @deprecated use {@see \Aedart\Contracts\Streams\Locks\LockType::EXCLUSIVE} instead, since v10.x
     */
    #[\Deprecated(message: "use \Aedart\Contracts\Streams\Locks\LockType::EXCLUSIVE instead", since: "10.x")]
    public const int EXCLUSIVE = 2;
}
