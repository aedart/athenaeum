<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Public path Aware
 *
 * Component is aware of string "public path"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface PublicPathAware
{
    /**
     * Set public path
     *
     * @param string|null $path Directory path where public resources are located
     *
     * @return self
     */
    public function setPublicPath(string|null $path): static;

    /**
     * Get public path
     *
     * If no public path value set, method
     * sets and returns a default public path.
     *
     * @see getDefaultPublicPath()
     *
     * @return string|null public path or null if no public path has been set
     */
    public function getPublicPath(): string|null;

    /**
     * Check if public path has been set
     *
     * @return bool True if public path has been set, false if not
     */
    public function hasPublicPath(): bool;

    /**
     * Get a default public path value, if any is available
     *
     * @return string|null Default public path value or null if no default value is available
     */
    public function getDefaultPublicPath(): string|null;
}
