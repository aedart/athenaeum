<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Resource path Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\ResourcePathAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait ResourcePathTrait
{
    /**
     * Directory path where your resources are located
     *
     * @var string|null
     */
    protected string|null $resourcePath = null;

    /**
     * Set resource path
     *
     * @param string|null $path Directory path where your resources are located
     *
     * @return self
     */
    public function setResourcePath(string|null $path): static
    {
        $this->resourcePath = $path;

        return $this;
    }

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
    public function getResourcePath(): string|null
    {
        if (!$this->hasResourcePath()) {
            $this->setResourcePath($this->getDefaultResourcePath());
        }
        return $this->resourcePath;
    }

    /**
     * Check if resource path has been set
     *
     * @return bool True if resource path has been set, false if not
     */
    public function hasResourcePath(): bool
    {
        return isset($this->resourcePath);
    }

    /**
     * Get a default resource path value, if any is available
     *
     * @return string|null Default resource path value or null if no default value is available
     */
    public function getDefaultResourcePath(): string|null
    {
        return null;
    }
}
