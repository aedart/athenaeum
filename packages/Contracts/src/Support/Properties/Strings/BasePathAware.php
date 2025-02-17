<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Base path Aware
 *
 * Component is aware of string "base path"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface BasePathAware
{
    /**
     * Set base path
     *
     * @param string|null $path The path to the root directory of some kind of a resource, e.g. your application, files, pictures,...etc
     *
     * @return self
     */
    public function setBasePath(string|null $path): static;

    /**
     * Get base path
     *
     * If no base path value set, method
     * sets and returns a default base path.
     *
     * @see getDefaultBasePath()
     *
     * @return string|null base path or null if no base path has been set
     */
    public function getBasePath(): string|null;

    /**
     * Check if base path has been set
     *
     * @return bool True if base path has been set, false if not
     */
    public function hasBasePath(): bool;

    /**
     * Get a default base path value, if any is available
     *
     * @return string|null Default base path value or null if no default value is available
     */
    public function getDefaultBasePath(): string|null;
}
