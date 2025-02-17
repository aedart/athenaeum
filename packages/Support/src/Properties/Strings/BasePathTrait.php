<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Base path Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\BasePathAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait BasePathTrait
{
    /**
     * The path to the root directory of some kind of a resource, e.g. your application, files, pictures,...etc
     *
     * @var string|null
     */
    protected string|null $basePath = null;

    /**
     * Set base path
     *
     * @param string|null $path The path to the root directory of some kind of a resource, e.g. your application, files, pictures,...etc
     *
     * @return self
     */
    public function setBasePath(string|null $path): static
    {
        $this->basePath = $path;

        return $this;
    }

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
    public function getBasePath(): string|null
    {
        if (!$this->hasBasePath()) {
            $this->setBasePath($this->getDefaultBasePath());
        }
        return $this->basePath;
    }

    /**
     * Check if base path has been set
     *
     * @return bool True if base path has been set, false if not
     */
    public function hasBasePath(): bool
    {
        return isset($this->basePath);
    }

    /**
     * Get a default base path value, if any is available
     *
     * @return string|null Default base path value or null if no default value is available
     */
    public function getDefaultBasePath(): string|null
    {
        return null;
    }
}
