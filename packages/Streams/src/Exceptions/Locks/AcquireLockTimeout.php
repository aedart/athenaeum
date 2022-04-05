<?php

namespace Aedart\Streams\Exceptions\Locks;

/**
 * Acquire Lock Timeout
 *
 * Should be thrown timeout has been reached and no lock was acquired
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Streams\Exceptions\Locks
 */
class AcquireLockTimeout extends LockFailure
{
}
