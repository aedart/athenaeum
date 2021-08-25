<?php

namespace Aedart\Tests\TestCases\Redmine;

use Aedart\Config\Providers\ConfigLoaderServiceProvider;
use Aedart\Config\Traits\ConfigLoaderTrait;
use Aedart\Http\Clients\Providers\HttpClientServiceProvider;
use Aedart\Redmine\Providers\RedmineServiceProvider;
use Aedart\Support\Helpers\Config\ConfigTrait;
use Aedart\Testing\TestCases\LaravelTestCase;
use Codeception\Configuration;
use Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables;

/**
 * Redmine Test Case
 *
 * Base test case for the Redmine package components
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\TestCases\Redmine
 */
abstract class RedmineTestCase extends LaravelTestCase
{
    use ConfigLoaderTrait;
    use ConfigTrait;

    /*****************************************************************
     * Setup Methods
     ****************************************************************/

    /**
     * {@inheritdoc}
     */
    protected function _before()
    {
        parent::_before();

        $this->getConfigLoader()
            ->setDirectory($this->directory())
            ->load();
    }

    /**
     * {@inheritdoc}
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
            HttpClientServiceProvider::class,
            RedmineServiceProvider::class
        ];
    }

    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Returns the path to configuration files
     *
     * @return string
     */
    public function directory(): string
    {
        return Configuration::dataDir() . 'configs/redmine';
    }

    /**
     * @inheritdoc
     */
    protected function getEnvironmentSetUp($app)
    {
        // Ensure .env is loaded
        $app->useEnvironmentPath(__DIR__ . '/../../../');
        $app->loadEnvironmentFrom('.testing');
        $app->bootstrapWith([LoadEnvironmentVariables::class]);
    }
}
