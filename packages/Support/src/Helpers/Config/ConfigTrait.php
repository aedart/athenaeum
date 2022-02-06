<?php

namespace Aedart\Support\Helpers\Config;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\Facades\Config;

/**
 * Config Trait
 *
 * @see \Aedart\Contracts\Support\Helpers\Config\ConfigAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Helpers\Config
 */
trait ConfigTrait
{
    /**
     * Configuration Repository instance
     *
     * @var Repository|null
     */
    protected Repository|null $config = null;

    /**
     * Set config
     *
     * @param Repository|null $repository Configuration Repository instance
     *
     * @return self
     */
    public function setConfig(Repository|null $repository): static
    {
        $this->config = $repository;

        return $this;
    }

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
    public function getConfig(): Repository|null
    {
        if (!$this->hasConfig()) {
            $this->setConfig($this->getDefaultConfig());
        }
        return $this->config;
    }

    /**
     * Check if config has been set
     *
     * @return bool True if config has been set, false if not
     */
    public function hasConfig(): bool
    {
        return isset($this->config);
    }

    /**
     * Get a default config value, if any is available
     *
     * @return Repository|null A default config value or Null if no default value is available
     */
    public function getDefaultConfig(): Repository|null
    {
        return Config::getFacadeRoot();
    }
}
