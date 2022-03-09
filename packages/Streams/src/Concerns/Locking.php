<?php

namespace Aedart\Streams\Concerns;

use Aedart\Contracts\Streams\Locks\Factory;
use Aedart\Contracts\Streams\Locks\LockTypes;
use Aedart\Streams\Locks\LockFactory;
use Aedart\Streams\Traits\LockFactoryTrait;
use Aedart\Support\Facades\IoCFacade;

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

    /**
     * @inheritdoc
     */
    public function lock(
        callable $operation,
        int $type = LockTypes::EXCLUSIVE,
        float $timeout = 0.5,
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
        float $timeout = 0.5,
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
        float $timeout = 0.5,
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

    /**
     * @inheritDoc
     */
    public function getDefaultLockFactory(): Factory|null
    {
        return IoCFacade::tryMake(Factory::class, new LockFactory());
    }
}
