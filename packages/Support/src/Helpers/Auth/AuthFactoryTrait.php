<?php

namespace Aedart\Support\Helpers\Auth;

use Illuminate\Contracts\Auth\Factory;
use Illuminate\Support\Facades\Auth;

/**
 * Auth Factory Trait
 *
 * @see \Aedart\Contracts\Support\Helpers\Auth\AuthFactoryAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Helpers\Auth
 */
trait AuthFactoryTrait
{
    /**
     * Auth Factory instance
     *
     * @var Factory|null
     */
    protected Factory|null $authFactory = null;

    /**
     * Set auth factory
     *
     * @param Factory|null $factory Auth Factory instance
     *
     * @return self
     */
    public function setAuthFactory(Factory|null $factory): static
    {
        $this->authFactory = $factory;

        return $this;
    }

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
    public function getAuthFactory(): Factory|null
    {
        if (!$this->hasAuthFactory()) {
            $this->setAuthFactory($this->getDefaultAuthFactory());
        }
        return $this->authFactory;
    }

    /**
     * Check if auth factory has been set
     *
     * @return bool True if auth factory has been set, false if not
     */
    public function hasAuthFactory(): bool
    {
        return isset($this->authFactory);
    }

    /**
     * Get a default auth factory value, if any is available
     *
     * @return Factory|null A default auth factory value or Null if no default value is available
     */
    public function getDefaultAuthFactory(): Factory|null
    {
        return Auth::getFacadeRoot();
    }
}
