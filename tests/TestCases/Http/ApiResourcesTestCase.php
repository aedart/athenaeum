<?php

namespace Aedart\Tests\TestCases\Http;

use Aedart\Config\Providers\ConfigLoaderServiceProvider;
use Aedart\Config\Traits\ConfigLoaderTrait;
use Aedart\Contracts\Config\Loaders\Exceptions\InvalidPathException;
use Aedart\Contracts\Config\Parsers\Exceptions\FileParserException;
use Aedart\Http\Api\Providers\ApiResourceServiceProvider;
use Aedart\Http\Api\Traits\ApiResourceRegistrarTrait;
use Aedart\Support\Helpers\Config\ConfigTrait;
use Aedart\Testing\TestCases\LaravelTestCase;
use Codeception\Configuration;

/**
 * Api Resources Test Case
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\TestCases\Http
 */
abstract class ApiResourcesTestCase extends LaravelTestCase
{
    use ConfigLoaderTrait;
    use ConfigTrait;
    use ApiResourceRegistrarTrait;

    /*****************************************************************
     * Setup Methods
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

        $this->installMigrations();

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
    protected function getPackageProviders($app): array
    {
        return [
            ConfigLoaderServiceProvider::class,
            ApiResourceServiceProvider::class
        ];
    }

    /**
     * @inheritdoc
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testing');

        // Enable foreign key constraints for SQLite testing database
        $app['config']->set('database.connections.testing.foreign_key_constraints', true);
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
        return Configuration::dataDir() . 'configs/http/api/';
    }

    /**
     * Returns paths to where database migrations are located
     *
     * @return string
     */
    public function migrationsDir(): string
    {
        return __DIR__ . '/../../_data/http/api/migrations';
    }

    /**
     * Runs the database migrations for the ACL package
     *
     * @return self
     */
    public function installMigrations(): self
    {
        // Install default migrations
        // $this->loadLaravelMigrations();

        // Install custom migrations
        $this->loadMigrationsFrom(
            $this->migrationsDir()
        );

        return $this;
    }
}