<?php

namespace Aedart\Tests\TestCases\MimeTypes;

use Aedart\Config\Providers\ConfigLoaderServiceProvider;
use Aedart\Config\Traits\ConfigLoaderTrait;
use Aedart\MimeTypes\Providers\MimeTypesDetectionServiceProvider;
use Aedart\Support\Helpers\Config\ConfigTrait;
use Aedart\Testing\TestCases\LaravelTestCase;
use Codeception\Configuration;

/**
 * Mime-Types Test-Case
 *
 * Base test case for the mime-types package components
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\TestCases\MimeTypes
 */
abstract class MimeTypesTestCase extends LaravelTestCase
{
    use ConfigLoaderTrait;
    use ConfigTrait;

    /*****************************************************************
     * Setup
     ****************************************************************/

    /**
     * {@inheritdoc}
     *
     * @throws \Aedart\Contracts\Config\Loaders\Exceptions\InvalidPathException
     */
    protected function _before()
    {
        parent::_before();

        $this->getConfigLoader()
            ->setDirectory($this->configDir())
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
            MimeTypesDetectionServiceProvider::class
        ];
    }

    /**
     * Returns the path to configuration files
     *
     * @return string
     */
    public function configDir(): string
    {
        return Configuration::dataDir() . 'configs/mime-types';
    }
}
