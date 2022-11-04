<?php

namespace Aedart\Tests\TestCases\ETags;

use Aedart\Config\Providers\ConfigLoaderServiceProvider;
use Aedart\Config\Traits\ConfigLoaderTrait;
use Aedart\Contracts\ETags\Exceptions\ProfileNotFoundException;
use Aedart\Contracts\ETags\Generator;
use Aedart\ETags\Providers\ETagsServiceProvider;
use Aedart\ETags\Traits\ETagGeneratorFactoryTrait;
use Aedart\Testing\TestCases\LaravelTestCase;
use Codeception\Configuration;

/**
 * Etags Test Case
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\TestCases\ETags
 */
abstract class ETagsTestCase extends LaravelTestCase
{
    use ETagGeneratorFactoryTrait;
    use ConfigLoaderTrait;

    /*****************************************************************
     * Setup
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
            ETagsServiceProvider::class,
        ];
    }

    /**
     * Returns the path to configuration files
     *
     * @return string
     */
    public function directory(): string
    {
        return Configuration::dataDir() . 'configs/etags';
    }

    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Creates new ETag Generator or returns existing
     *
     * @see \Aedart\Contracts\ETags\Factory::make
     *
     * @param  string|null  $profile  [optional]
     * @param  array  $options  [optional]
     *
     * @return Generator
     *
     * @throws ProfileNotFoundException
     */
    public function makeGenerator(string|null $profile = null, array $options = []): Generator
    {
        return $this->getEtagGeneratorFactory()->make($profile, $options);
    }
}