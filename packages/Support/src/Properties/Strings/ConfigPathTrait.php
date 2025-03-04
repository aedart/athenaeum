<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Config path Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\ConfigPathAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait ConfigPathTrait
{
    /**
     * Directory path where configuration files or resources located
     *
     * @var string|null
     */
    protected string|null $configPath = null;

    /**
     * Set config path
     *
     * @param string|null $path Directory path where configuration files or resources located
     *
     * @return self
     */
    public function setConfigPath(string|null $path): static
    {
        $this->configPath = $path;

        return $this;
    }

    /**
     * Get config path
     *
     * If no config path value set, method
     * sets and returns a default config path.
     *
     * @see getDefaultConfigPath()
     *
     * @return string|null config path or null if no config path has been set
     */
    public function getConfigPath(): string|null
    {
        if (!$this->hasConfigPath()) {
            $this->setConfigPath($this->getDefaultConfigPath());
        }
        return $this->configPath;
    }

    /**
     * Check if config path has been set
     *
     * @return bool True if config path has been set, false if not
     */
    public function hasConfigPath(): bool
    {
        return isset($this->configPath);
    }

    /**
     * Get a default config path value, if any is available
     *
     * @return string|null Default config path value or null if no default value is available
     */
    public function getDefaultConfigPath(): string|null
    {
        return null;
    }
}
