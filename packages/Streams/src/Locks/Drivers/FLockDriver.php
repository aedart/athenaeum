<?php

namespace Aedart\Streams\Locks\Drivers;

use Aedart\Contracts\Streams\Locks\LockTypes;
use Aedart\Contracts\Streams\Stream;
use Aedart\Streams\Exceptions\Locks\AcquireLockTimeout;
use InvalidArgumentException;

/**
 * Flock Driver
 *
 * @see https://www.php.net/manual/en/function.flock
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Streams\Locks\Drivers
 */
class FLockDriver extends BaseLockDriver
{
    /**
     * Lock type map
     *
     * @var array
     */
    protected static array $lockTypeMap = [
        LockTypes::SHARED => LOCK_SH,
        LockTypes::EXCLUSIVE => LOCK_EX,
    ];

    /**
     * @inheritDoc
     */
    public function acquireLock(Stream $stream, int $type, float $timeout): bool
    {
        if (!isset(static::$lockTypeMap[$type])) {
            throw new InvalidArgumentException(sprintf('Lock type %d is not supported', $type));
        }

        $type = static::$lockTypeMap[$type];

        // Resolve sleep duration (microsecond) Default = 0.01 seconds
        $sleep = $this->get('sleep', 10_000);
        if ($sleep < 1) {
            throw new InvalidArgumentException(sprintf('Sleep duration cannot be less than 1. %d given', $sleep));
        }

        $resource = $stream->resource();
        $start = microtime(true);

        // Attempt to acquire lock
        while (flock($resource, $type | LOCK_NB, $blocking) === false) {
            // Continue if timeout not reached
            $delta = (microtime(true) - $start);
            if ($blocking && $delta <= $timeout) {
                usleep($sleep);
                continue;
            }

            // Timeout has been reached! Fail if required
            if ($this->get('fail_on_timeout', true)) {
                throw new AcquireLockTimeout(sprintf('Timeout has been reached (%s sec.). Lock was not acquired!', $timeout));
            }

            // Otherwise, just abort...
            return false;
        }

        // If reached here, it means that the lock was successfully acquire...
        return true;
    }

    /**
     * @inheritDoc
     */
    public function releaseLock(Stream $stream): bool
    {
        return flock($stream->resource(), LOCK_UN);
    }
}
