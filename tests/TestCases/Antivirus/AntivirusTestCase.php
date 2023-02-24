<?php

namespace Aedart\Tests\TestCases\Antivirus;

use Aedart\Antivirus\Providers\AntivirusServiceProvider;
use Aedart\Antivirus\Traits\AntivirusManagerTrait;
use Aedart\Config\Providers\ConfigLoaderServiceProvider;
use Aedart\Config\Traits\ConfigLoaderTrait;
use Aedart\Contracts\Config\Loaders\Exceptions\InvalidPathException;
use Aedart\Contracts\Config\Parsers\Exceptions\FileParserException;
use Aedart\Testing\TestCases\LaravelTestCase;
use Codeception\Configuration;

/**
 * Antivirus Test Case
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\TestCases\Antivirus
 */
abstract class AntivirusTestCase extends LaravelTestCase
{
    use ConfigLoaderTrait;
    use AntivirusManagerTrait;

    /*****************************************************************
     * Setup
     ****************************************************************/

    /**
     * {@inheritdoc}
     *
     * @throws InvalidPathException
     * @throws FileParserException
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
    protected function getPackageProviders($app)
    {
        return [
            ConfigLoaderServiceProvider::class,
            AntivirusServiceProvider::class
        ];
    }

    /**
     * Returns the path to configuration files
     *
     * @return string
     */
    public function configDir(): string
    {
        return Configuration::dataDir() . 'configs/antivirus';
    }

    /*****************************************************************
     * Helpers
     ****************************************************************/

}