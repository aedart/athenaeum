<?php

namespace Aedart\Contracts\Config\Loaders;

use Aedart\Contracts\Config\Loader;

/**
 * Config Loader Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Config\Loaders
 */
interface ConfigLoaderAware
{
    /**
     * Set config loader
     *
     * @param Loader|null $loader Configuration Loader instance
     *
     * @return self
     */
    public function setConfigLoader(Loader|null $loader): static;

    /**
     * Get config loader
     *
     * If no config loader has been set, this method will
     * set and return a default config loader, if any such
     * value is available
     *
     * @see getDefaultConfigLoader()
     *
     * @return Loader|null config loader or null if none config loader has been set
     */
    public function getConfigLoader(): Loader|null;

    /**
     * Check if config loader has been set
     *
     * @return bool True if config loader has been set, false if not
     */
    public function hasConfigLoader(): bool;

    /**
     * Get a default config loader value, if any is available
     *
     * @return Loader|null A default config loader value or Null if no default value is available
     */
    public function getDefaultConfigLoader(): Loader|null;
}
