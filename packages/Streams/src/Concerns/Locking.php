<?php

namespace Aedart\Streams\Concerns;

use Aedart\Contracts\Streams\Locks\LockTypes;
use Aedart\Streams\Traits\LockFactoryTrait;

/**
 * Concerns Locking
 *
 * @see \Aedart\Contracts\Streams\Locks\LockOperations
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Streams\Concerns
 */
trait Locking
{
    use LockFactoryTrait;

    // TODO: DEFAULT LOCK FACTORY...

    /**
     * @inheritdoc
     */
    public function lock(
        callable $operation,
        int $type = LockTypes::EXCLUSIVE,
        int $timeout = 500_000,
        string|null $profile = null,
        array $options = []
    ): mixed
    {
        // TODO: Implement method
    }

    /**
     * @inheritdoc
     */
    public function exclusiveLock(
        callable $operation,
        int $timeout = 500_000,
        string|null $profile = null,
        array $options = []
    ): mixed
    {
        return $this->lock(
            $operation,
            LockTypes::EXCLUSIVE,
            $timeout,
            $profile,
            $options
        );
    }

    /**
     * @inheritdoc
     */
    public function sharedLock(
        callable $operation,
        int $timeout = 500_000,
        string|null $profile = null,
        array $options = []
    ): mixed
    {
        return $this->lock(
            $operation,
            LockTypes::SHARED,
            $timeout,
            $profile,
            $options
        );
    }
}
