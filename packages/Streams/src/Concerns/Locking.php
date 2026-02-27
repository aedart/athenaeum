<?php

namespace Aedart\Streams\Concerns;

use Aedart\Contracts\Streams\Locks\Factory;
use Aedart\Contracts\Streams\Locks\LockType;
use Aedart\Streams\Locks\LockFactory;
use Aedart\Streams\Traits\LockFactoryTrait;
use Aedart\Support\Facades\IoCFacade;

/**
 * Concerns Locking
 *
 * @see \Aedart\Contracts\Streams\Locks\Lockable
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Streams\Concerns
 */
trait Locking
{
    use LockFactoryTrait;

    /**
     * @inheritdoc
     */
    public function lock(
        callable $operation,
        int|LockType $type = LockType::EXCLUSIVE,
        float $timeout = 0.5,
        string|null $profile = null,
        array $options = []
    ): mixed {
        $lock = $this->getLockFactory()->create($this, $profile, $options);

        try {
            $acquired = $lock->acquire($type, $timeout);

            // Depending on implementation, a lock might not throw an
            // exception when unable to acquire a lock. This must also
            // be respected here - we do not throw an exception, only
            // return null...
            if (!$acquired) {
                return null;
            }

            return $operation($this, $lock);
        } finally {
            $lock->release();
        }
    }

    /**
     * @inheritdoc
     */
    public function exclusiveLock(
        callable $operation,
        float $timeout = 0.5,
        string|null $profile = null,
        array $options = []
    ): mixed {
        return $this->lock(
            $operation,
            LockType::EXCLUSIVE,
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
        float $timeout = 0.5,
        string|null $profile = null,
        array $options = []
    ): mixed {
        return $this->lock(
            $operation,
            LockType::SHARED,
            $timeout,
            $profile,
            $options
        );
    }

    /**
     * @inheritDoc
     */
    public function getDefaultLockFactory(): Factory|null
    {
        return IoCFacade::tryMake(Factory::class, new LockFactory());
    }
}
