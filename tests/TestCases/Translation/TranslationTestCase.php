<?php

namespace Aedart\Tests\TestCases\Translation;

use Aedart\Config\Providers\ConfigLoaderServiceProvider;
use Aedart\Config\Traits\ConfigLoaderTrait;
use Aedart\Contracts\Config\Loaders\Exceptions\InvalidPathException;
use Aedart\Contracts\Config\Parsers\Exceptions\FileParserException;
use Aedart\Contracts\Translation\Exports\Exceptions\ProfileNotFoundException;
use Aedart\Contracts\Translation\Exports\Exporter;
use Aedart\Http\Api\Providers\JsonResourceServiceProvider;
use Aedart\Support\Helpers\Translation\TranslatorTrait;
use Aedart\Testing\TestCases\LaravelTestCase;
use Aedart\Tests\Helpers\Dummies\Translation\AcmeTranslationsServiceProvider;
use Aedart\Tests\Helpers\Dummies\Translation\DeferrableTranslationsServiceProvider;
use Aedart\Translation\Providers\TranslationsExporterServiceProvider;
use Aedart\Translation\Traits\TranslationsExporterManagerTrait;
use Codeception\Configuration;

/**
 * Translation Test Case
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\TestCases\Translation
 */
abstract class TranslationTestCase extends LaravelTestCase
{
    use TranslatorTrait;
    use ConfigLoaderTrait;
    use TranslationsExporterManagerTrait;

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
            TranslationsExporterServiceProvider::class,

            // Packages that publishes or load translations...
            JsonResourceServiceProvider::class,
            AcmeTranslationsServiceProvider::class,
            DeferrableTranslationsServiceProvider::class
        ];
    }

    /**
     * Returns the path to configuration files
     *
     * @return string
     */
    public function configDir(): string
    {
        return Configuration::dataDir() . 'configs/translation';
    }

    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Returns exporter that matches given profile
     *
     * @param string|null $profile [optional]
     * @param array $options [optional]
     *
     * @return Exporter
     *
     * @throws ProfileNotFoundException
     */
    public function makeExporter(string|null $profile = null, array $options = []): Exporter
    {
        return $this->getTranslationsExporterManager()->profile($profile, $options);
    }
}
