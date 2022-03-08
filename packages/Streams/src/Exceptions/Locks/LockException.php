<?php

namespace Aedart\Streams\Exceptions\Locks;

use Aedart\Contracts\Streams\Exceptions\LockException as LockExceptionInterface;
use RuntimeException;

/**
 * Lock Exception
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Streams\Exceptions\Locks
 */
class LockException extends RuntimeException implements LockExceptionInterface
{
}
