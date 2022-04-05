<?php

namespace Aedart\Contracts\Streams\Locks;

/**
 * Lock Factory Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Streams\Locks
 */
interface LockFactoryAware
{
    /**
     * Set lock factory
     *
     * @param  Factory|null  $factory  Stream Lock Factory instance
     *
     * @return self
     */
    public function setLockFactory(Factory|null $factory): static;

    /**
     * Get lock factory
     *
     * If no lock factory has been set, this method will
     * set and return a default lock factory, if any such
     * value is available
     *
     * @return Factory|null lock factory or null if none lock factory has been set
     */
    public function getLockFactory(): Factory|null;

    /**
     * Check if lock factory has been set
     *
     * @return bool True if lock factory has been set, false if not
     */
    public function hasLockFactory(): bool;

    /**
     * Get a default lock factory value, if any is available
     *
     * @return Factory|null A default lock factory value or Null if no default value is available
     */
    public function getDefaultLockFactory(): Factory|null;
}
