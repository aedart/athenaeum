<?php

namespace Aedart\Contracts\Support\Helpers\Container;

use Illuminate\Contracts\Container\Container;

/**
 * Container Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Helpers\Container
 */
interface ContainerAware
{
    /**
     * Set container
     *
     * @param Container|null $container IoC Service Container instance
     *
     * @return self
     */
    public function setContainer(Container|null $container): static;

    /**
     * Get container
     *
     * If no container has been set, this method will
     * set and return a default container, if any such
     * value is available
     *
     * @see getDefaultContainer()
     *
     * @return Container|null container or null if none container has been set
     */
    public function getContainer(): Container|null;

    /**
     * Check if container has been set
     *
     * @return bool True if container has been set, false if not
     */
    public function hasContainer(): bool;

    /**
     * Get a default container value, if any is available
     *
     * @return Container|null A default container value or Null if no default value is available
     */
    public function getDefaultContainer(): Container|null;
}
