<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Environment path Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\EnvironmentPathAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait EnvironmentPathTrait
{
    /**
     * Directory path where your environment resources are located
     *
     * @var string|null
     */
    protected string|null $environmentPath = null;

    /**
     * Set environment path
     *
     * @param string|null $path Directory path where your environment resources are located
     *
     * @return self
     */
    public function setEnvironmentPath(string|null $path): static
    {
        $this->environmentPath = $path;

        return $this;
    }

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
    public function getEnvironmentPath(): string|null
    {
        if (!$this->hasEnvironmentPath()) {
            $this->setEnvironmentPath($this->getDefaultEnvironmentPath());
        }
        return $this->environmentPath;
    }

    /**
     * Check if environment path has been set
     *
     * @return bool True if environment path has been set, false if not
     */
    public function hasEnvironmentPath(): bool
    {
        return isset($this->environmentPath);
    }

    /**
     * Get a default environment path value, if any is available
     *
     * @return string|null Default environment path value or null if no default value is available
     */
    public function getDefaultEnvironmentPath(): string|null
    {
        return null;
    }
}
