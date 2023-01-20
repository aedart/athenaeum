<?php

namespace Aedart\Testing\Laravel\Bootstrap;

use Generator;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Config\Repository as RepositoryContract;
use Illuminate\Contracts\Foundation\Application;
use Symfony\Component\Finder\Finder;

/**
 * Load Specified Configuration
 *
 * Allows specifying location of configuration files directory.
 *
 * @see \Orchestra\Testbench\Bootstrap\LoadConfiguration
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Testing\Laravel\Bootstrap
 */
class LoadSpecifiedConfiguration
{
    /**
     * Path where configuration files are located
     *
     * @var string|null
     */
    protected string|null $configurationPath = null;

    /**
     * Set path to where configuration must be loaded from
     *
     * @param string|null $path [optional]
     *
     * @return self
     */
    public function setConfigurationPath(string|null $path = null): static
    {
        $this->configurationPath = $path;

        return $this;
    }

    /**
     * Get path to where configuration must be loaded from
     *
     * @return string|null
     */
    public function getConfigurationPath(): string|null
    {
        return $this->configurationPath;
    }

    /**
     * Bootstrap the given application.
     *
     * @param  Application  $app
     *
     * @return void
     */
    public function bootstrap(Application $app): void
    {
        $app->instance('config', $config = new Repository([]));

        $this->loadConfigurationFiles($app, $config);

        mb_internal_encoding('UTF-8');
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Load the configuration items from all files.
     *
     * @see getConfigurationFiles
     *
     * @param  Application  $app
     * @param  RepositoryContract  $config
     *
     * @return void
     */
    protected function loadConfigurationFiles(Application $app, RepositoryContract $config): void
    {
        foreach ($this->getConfigurationFiles($app) as $key => $path) {
            $config->set($key, require $path);
        }
    }

    /**
     * Get all configuration files for application
     *
     * @param  Application  $app
     *
     * @return Generator
     */
    protected function getConfigurationFiles(Application $app): Generator
    {
        $path = $this->getConfigurationPath();

        foreach (Finder::create()->files()->name('*.php')->in($path) as $file) {
            yield basename($file->getRealPath(), '.php') => $file->getRealPath();
        }
    }
}
