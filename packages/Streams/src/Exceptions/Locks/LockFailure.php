<?php

namespace Aedart\Streams\Exceptions\Locks;

/**
 * Lock Failure
 *
 * Should be thrown whenever lock could not be acquired or a failure
 * happened during acquire process.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Streams\Exceptions\Locks
 */
class LockFailure extends LockException
{
}
