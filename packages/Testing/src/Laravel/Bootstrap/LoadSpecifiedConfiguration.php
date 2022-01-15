<?php

namespace Aedart\Testing\Laravel\Bootstrap;

use Generator;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Config\Repository as RepositoryContract;
use Illuminate\Contracts\Foundation\Application;
//use Orchestra\Testbench\Bootstrap\LoadConfiguration as BaseLoadConfiguration;
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
class LoadSpecifiedConfiguration
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
     * Bootstrap the given application.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
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
     * Load the configuration items from all of the files.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @param  \Illuminate\Contracts\Config\Repository  $config
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
