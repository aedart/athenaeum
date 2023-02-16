<?php

namespace Aedart\Tests\TestCases\Maintenance\Modes;

use Aedart\Config\Providers\ConfigLoaderServiceProvider;
use Aedart\Config\Traits\ConfigLoaderTrait;
use Aedart\Maintenance\Modes\FallbackManager;
use Aedart\Maintenance\Modes\Providers\MaintenanceModeServiceProvider;
use Aedart\Maintenance\Modes\Traits\MaintenanceModeManagerTrait;
use Aedart\Support\Helpers\Container\ContainerTrait;
use Aedart\Support\Helpers\Filesystem\FileTrait;
use Aedart\Testing\TestCases\LaravelTestCase;
use Codeception\Configuration;

/**
 * Maintenance Modes Test Case
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\TestCases\Maintenance\Modes
 */
abstract class MaintenanceModesTestCase extends LaravelTestCase
{
    use MaintenanceModeManagerTrait;
    use ConfigLoaderTrait;
    use ContainerTrait;
    use FileTrait;

    /*****************************************************************
     * Setup Methods
     ****************************************************************/

    /**
     * @inheritDoc
     */
    protected function _before()
    {
        parent::_before();

        $this->getConfigLoader()
            ->setDirectory($this->directory())
            ->load();

        $fs = $this->getFile();
        $outputDir = $this->outputDir();

        $fs->ensureDirectoryExists($outputDir);
        $fs->cleanDirectory($outputDir);
    }

    /**
     * @inheritDoc
     */
    protected function _after()
    {
        parent::_after();
    }

    /**
     * {@inheritdoc}
     */
    protected function getPackageProviders($app)
    {
        return [
            ConfigLoaderServiceProvider::class,
            MaintenanceModeServiceProvider::class
        ];
    }

    /**
     * Returns the path to configuration files
     *
     * @return string
     */
    public function directory(): string
    {
        return Configuration::dataDir() . 'configs/maintenance/modes';
    }

    /**
     * Output directory
     *
     * @return string
     *
     * @throws \Codeception\Exception\ConfigurationException
     */
    public function outputDir(): string
    {
        return Configuration::outputDir() . 'maintenance/modes';
    }

    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Creates fallback maintenance manager instance
     *
     * @return FallbackManager
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function createFallbackManager(): FallbackManager
    {
        return $this->getContainer()->make(FallbackManager::class);
    }
}
