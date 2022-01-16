<?php

namespace Aedart\Tests\TestCases\Maintenance\Modes;

use Aedart\Config\Providers\ConfigLoaderServiceProvider;
use Aedart\Config\Traits\ConfigLoaderTrait;
use Aedart\Http\Clients\Providers\HttpClientServiceProvider;
use Aedart\Maintenance\Modes\FallbackManager;
use Aedart\Maintenance\Modes\Providers\MaintenanceModeServiceProvider;
use Aedart\Maintenance\Modes\Traits\MaintenanceModeManagerTrait;
use Aedart\Support\Helpers\Container\ContainerTrait;
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
