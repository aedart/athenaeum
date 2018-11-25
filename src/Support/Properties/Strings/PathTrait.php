<?php

namespace Aedart\Support\Properties\Strings;

/**
 * Path Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\PathAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait PathTrait
{
    /**
     * Location of some kind of a resources, e.g. a file, an Url, an index
     *
     * @var string|null
     */
    protected $path = null;

    /**
     * Set path
     *
     * @param string|null $location Location of some kind of a resources, e.g. a file, an Url, an index
     *
     * @return self
     */
    public function setPath(?string $location)
    {
        $this->path = $location;

        return $this;
    }

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
    public function getPath() : ?string
    {
        if ( ! $this->hasPath()) {
            $this->setPath($this->getDefaultPath());
        }
        return $this->path;
    }

    /**
     * Check if "path" has been set
     *
     * @return bool True if "path" has been set, false if not
     */
    public function hasPath() : bool
    {
        return isset($this->path);
    }

    /**
     * Get a default "path" value, if any is available
     *
     * @return string|null Default "path" value or null if no default value is available
     */
    public function getDefaultPath() : ?string
    {
        return null;
    }
}
