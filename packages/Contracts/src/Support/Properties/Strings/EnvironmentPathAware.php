<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Environment path Aware
 *
 * Component is aware of string "environment path"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface EnvironmentPathAware
{
    /**
     * Set environment path
     *
     * @param string|null $path Directory path where your environment resources are located
     *
     * @return self
     */
    public function setEnvironmentPath(string|null $path): static;

    /**
     * Get environment path
     *
     * If no environment path value set, method
     * sets and returns a default environment path.
     *
     * @see getDefaultEnvironmentPath()
     *
     * @return string|null environment path or null if no environment path has been set
     */
    public function getEnvironmentPath(): string|null;

    /**
     * Check if environment path has been set
     *
     * @return bool True if environment path has been set, false if not
     */
    public function hasEnvironmentPath(): bool;

    /**
     * Get a default environment path value, if any is available
     *
     * @return string|null Default environment path value or null if no default value is available
     */
    public function getDefaultEnvironmentPath(): string|null;
}
