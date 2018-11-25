<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * Path Aware
 *
 * Component is aware of string "path"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface PathAware
{
    /**
     * Set path
     *
     * @param string|null $location Location of some kind of a resources, e.g. a file, an Url, an index
     *
     * @return self
     */
    public function setPath(?string $location);

    /**
     * Get path
     *
     * If no "path" value set, method
     * sets and returns a default "path".
     *
     * @see getDefaultPath()
     *
     * @return string|null path or null if no path has been set
     */
    public function getPath() : ?string;

    /**
     * Check if "path" has been set
     *
     * @return bool True if "path" has been set, false if not
     */
    public function hasPath() : bool;

    /**
     * Get a default "path" value, if any is available
     *
     * @return string|null Default "path" value or null if no default value is available
     */
    public function getDefaultPath() : ?string;
}
