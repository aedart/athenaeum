<?php

namespace Aedart\Contracts\Support\Helpers\Config;

use Illuminate\Contracts\Config\Repository;

/**
 * Config Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Helpers\Config
 */
interface ConfigAware
{
    /**
     * Set config
     *
     * @param Repository|null $repository Configuration Repository instance
     *
     * @return self
     */
    public function setConfig(?Repository $repository);

    /**
     * Get config
     *
     * If no config has been set, this method will
     * set and return a default config, if any such
     * value is available
     *
     * @see getDefaultConfig()
     *
     * @return Repository|null config or null if none config has been set
     */
    public function getConfig(): ?Repository;

    /**
     * Check if config has been set
     *
     * @return bool True if config has been set, false if not
     */
    public function hasConfig(): bool;

    /**
     * Get a default config value, if any is available
     *
     * @return Repository|null A default config value or Null if no default value is available
     */
    public function getDefaultConfig(): ?Repository;
}
