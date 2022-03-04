<?php

namespace Aedart\Streams\Traits;

use Aedart\Contracts\Streams\Locks\Factory;

/**
 * Lock Factory Trait
 *
 * @see \Aedart\Contracts\Streams\Locks\LockFactoryAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Streams\Traits
 */
trait LockFactoryTrait
{
    /**
     * Stream Lock Factory instance
     *
     * @var Factory|null
     */
    protected Factory|null $lockFactory = null;

    /**
     * Set lock factory
     *
     * @param  Factory|null  $factory  Stream Lock Factory instance
     *
     * @return self
     */
    public function setLockFactory(Factory|null $factory): static
    {
        $this->lockFactory = $factory;

        return $this;
    }

    /**
     * Get lock factory
     *
     * If no lock factory has been set, this method will
     * set and return a default lock factory, if any such
     * value is available
     *
     * @return Factory|null lock factory or null if none lock factory has been set
     */
    public function getLockFactory(): Factory|null
    {
        if (!$this->hasLockFactory()) {
            $this->setLockFactory($this->getDefaultLockFactory());
        }
        return $this->lockFactory;
    }

    /**
     * Check if lock factory has been set
     *
     * @return bool True if lock factory has been set, false if not
     */
    public function hasLockFactory(): bool
    {
        return isset($this->lockFactory);
    }

    /**
     * Get a default lock factory value, if any is available
     *
     * @return Factory|null A default lock factory value or Null if no default value is available
     */
    public function getDefaultLockFactory(): Factory|null
    {
        return null;
    }
}
