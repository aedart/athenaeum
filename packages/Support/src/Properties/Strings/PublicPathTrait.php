<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Public path Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\PublicPathAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait PublicPathTrait
{
    /**
     * Directory path where public resources are located
     *
     * @var string|null
     */
    protected string|null $publicPath = null;

    /**
     * Set public path
     *
     * @param string|null $path Directory path where public resources are located
     *
     * @return self
     */
    public function setPublicPath(string|null $path): static
    {
        $this->publicPath = $path;

        return $this;
    }

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
    public function getPublicPath(): string|null
    {
        if (!$this->hasPublicPath()) {
            $this->setPublicPath($this->getDefaultPublicPath());
        }
        return $this->publicPath;
    }

    /**
     * Check if public path has been set
     *
     * @return bool True if public path has been set, false if not
     */
    public function hasPublicPath(): bool
    {
        return isset($this->publicPath);
    }

    /**
     * Get a default public path value, if any is available
     *
     * @return string|null Default public path value or null if no default value is available
     */
    public function getDefaultPublicPath(): string|null
    {
        return null;
    }
}
