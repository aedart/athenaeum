<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Resource path Aware
 *
 * Component is aware of string "resource path"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface ResourcePathAware
{
    /**
     * Set resource path
     *
     * @param string|null $path Directory path where your resources are located
     *
     * @return self
     */
    public function setResourcePath(string|null $path): static;

    /**
     * Get resource path
     *
     * If no resource path value set, method
     * sets and returns a default resource path.
     *
     * @see getDefaultResourcePath()
     *
     * @return string|null resource path or null if no resource path has been set
     */
    public function getResourcePath(): string|null;

    /**
     * Check if resource path has been set
     *
     * @return bool True if resource path has been set, false if not
     */
    public function hasResourcePath(): bool;

    /**
     * Get a default resource path value, if any is available
     *
     * @return string|null Default resource path value or null if no default value is available
     */
    public function getDefaultResourcePath(): string|null;
}
