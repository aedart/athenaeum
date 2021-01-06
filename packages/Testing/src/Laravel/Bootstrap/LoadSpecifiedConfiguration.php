<?php

namespace Aedart\Testing\Laravel\Bootstrap;

use Generator;
use Illuminate\Contracts\Foundation\Application;
use Orchestra\Testbench\Bootstrap\LoadConfiguration as BaseLoadConfiguration;
use Symfony\Component\Finder\Finder;

/**
 * Load Specified Configuration
 *
 * Allows specifying location of configuration files directory.
 *
 * @see \Orchestra\Testbench\Bootstrap\LoadConfiguration
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Testing\Laravel\Bootstrap
 */
class LoadSpecifiedConfiguration extends BaseLoadConfiguration
{
    /**
     * Path where configuration files are located
     *
     * @var string|null
     */
    protected ?string $configurationPath = null;

    /**
     * Set path to where configuration must be loaded from
     *
     * @param string|null $path [optional]
     *
     * @return self
     */
    public function setConfigurationPath(?string $path = null)
    {
        $this->configurationPath = $path;

        return $this;
    }

    /**
     * Get path to where configuration must be loaded from
     *
     * @return string|null
     */
    public function getConfigurationPath(): ?string
    {
        return $this->configurationPath;
    }

    /**
     * @inheritdoc
     */
    protected function getConfigurationFiles(Application $app): Generator
    {
        $path = $this->getConfigurationPath();

        foreach (Finder::create()->files()->name('*.php')->in($path) as $file) {
            yield basename($file->getRealPath(), '.php') => $file->getRealPath();
        }
    }
}
