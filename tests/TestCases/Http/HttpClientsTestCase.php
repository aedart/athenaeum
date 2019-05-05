<?php

namespace Aedart\Tests\TestCases\Http;

use Aedart\Config\Providers\ConfigLoaderServiceProvider;
use Aedart\Config\Traits\ConfigLoaderTrait;
use Aedart\Http\Clients\Providers\HttpClientServiceProvider;
use Aedart\Http\Clients\Traits\HttpClientsManagerTrait;
use Aedart\Support\Helpers\Config\ConfigTrait;
use Aedart\Testing\TestCases\LaravelTestCase;
use Codeception\Configuration;

/**
 * Http Clients Test Case
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\TestCases\Http
 */
abstract class HttpClientsTestCase extends LaravelTestCase
{
    use ConfigLoaderTrait;
    use ConfigTrait;
    use HttpClientsManagerTrait;

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
    protected function getPackageProviders($app)
    {
        return [
            ConfigLoaderServiceProvider::class,
            HttpClientServiceProvider::class
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
    public function directory() : string
    {
        return Configuration::dataDir() . 'configs/http/clients/';
    }
}