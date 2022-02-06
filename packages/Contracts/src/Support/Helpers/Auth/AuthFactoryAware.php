<?php

namespace Aedart\Contracts\Support\Helpers\Auth;

use Illuminate\Contracts\Auth\Factory;

/**
 * Auth Factory Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Helpers\Auth
 */
interface AuthFactoryAware
{
    /**
     * Set auth factory
     *
     * @param Factory|null $factory Auth Factory instance
     *
     * @return self
     */
    public function setAuthFactory(Factory|null $factory): static;

    /**
     * Get auth factory
     *
     * If no auth factory has been set, this method will
     * set and return a default auth factory, if any such
     * value is available
     *
     * @see getDefaultAuthFactory()
     *
     * @return Factory|null auth factory or null if none auth factory has been set
     */
    public function getAuthFactory(): Factory|null;

    /**
     * Check if auth factory has been set
     *
     * @return bool True if auth factory has been set, false if not
     */
    public function hasAuthFactory(): bool;

    /**
     * Get a default auth factory value, if any is available
     *
     * @return Factory|null A default auth factory value or Null if no default value is available
     */
    public function getDefaultAuthFactory(): Factory|null;
}
