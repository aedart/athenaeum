<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Config path Aware
 *
 * Component is aware of string "config path"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface ConfigPathAware
{
    /**
     * Set config path
     *
     * @param string|null $path Directory path where configuration files or resources located
     *
     * @return self
     */
    public function setConfigPath(string|null $path): static;

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
    public function getConfigPath(): string|null;

    /**
     * Check if config path has been set
     *
     * @return bool True if config path has been set, false if not
     */
    public function hasConfigPath(): bool;

    /**
     * Get a default config path value, if any is available
     *
     * @return string|null Default config path value or null if no default value is available
     */
    public function getDefaultConfigPath(): string|null;
}
