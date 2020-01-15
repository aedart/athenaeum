<?php

namespace Aedart\Config\Traits;

use Aedart\Config\Facades\ConfigLoader;
use Aedart\Contracts\Config\Loader;

/**
 * Config Loader Trait
 *
 * @see \Aedart\Contracts\Config\Loaders\ConfigLoaderAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Config\Traits
 */
trait ConfigLoaderTrait
{
    /**
     * Configuration Loader instance
     *
     * @var Loader|null
     */
    protected ?Loader $configLoader = null;

    /**
     * Set config loader
     *
     * @param Loader|null $loader Configuration Loader instance
     *
     * @return self
     */
    public function setConfigLoader(?Loader $loader)
    {
        $this->configLoader = $loader;

        return $this;
    }

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
    public function getConfigLoader(): ?Loader
    {
        if (!$this->hasConfigLoader()) {
            $this->setConfigLoader($this->getDefaultConfigLoader());
        }
        return $this->configLoader;
    }

    /**
     * Check if config loader has been set
     *
     * @return bool True if config loader has been set, false if not
     */
    public function hasConfigLoader(): bool
    {
        return isset($this->configLoader);
    }

    /**
     * Get a default config loader value, if any is available
     *
     * @return Loader|null A default config loader value or Null if no default value is available
     */
    public function getDefaultConfigLoader(): ?Loader
    {
        return ConfigLoader::getFacadeRoot();
    }
}
