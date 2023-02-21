<?php

namespace Aedart\Tests\TestCases\Translation;

use Aedart\Config\Providers\ConfigLoaderServiceProvider;
use Aedart\Config\Traits\ConfigLoaderTrait;
use Aedart\Contracts\Config\Loaders\Exceptions\InvalidPathException;
use Aedart\Contracts\Config\Parsers\Exceptions\FileParserException;
use Aedart\Contracts\Translation\TranslationsLoader;
use Aedart\Http\Api\Providers\JsonResourceServiceProvider;
use Aedart\Support\Facades\IoCFacade;
use Aedart\Support\Helpers\Translation\TranslatorTrait;
use Aedart\Testing\TestCases\LaravelTestCase;
use Aedart\Tests\Helpers\Dummies\Translation\AcmeTranslationsServiceProvider;
use Aedart\Translation\Providers\TranslationsExporterServiceProvider;
use Aedart\Translation\Providers\TranslationsLoaderServiceProvider;
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
            TranslationsLoaderServiceProvider::class,
            TranslationsExporterServiceProvider::class,

            // Packages that publishes or load translations...
            JsonResourceServiceProvider::class,
            AcmeTranslationsServiceProvider::class
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
     * @deprecated
     *
     * Get the translation loader
     *
     * @return TranslationsLoader
     */
    public function getLoader(): TranslationsLoader
    {
        return IoCFacade::make(TranslationsLoader::class);
    }
}
