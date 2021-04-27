<?php

namespace Aedart\Tests\TestCases\Audit;

use Aedart\Audit\Providers\AuditTrailServiceProvider;
use Aedart\Config\Providers\ConfigLoaderServiceProvider;
use Aedart\Config\Traits\ConfigLoaderTrait;
use Aedart\Testing\TestCases\LaravelTestCase;
use Codeception\Configuration;

/**
 * Audit Test Case
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\TestCases\Audit
 */
abstract class AuditTestCase extends LaravelTestCase
{
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
            ->setDirectory($this->configDir())
            ->load();

        $this->installAuditMigrations();
    }

    /**
     * {@inheritdoc}
     */
    protected function getPackageProviders($app)
    {
        return [
            ConfigLoaderServiceProvider::class,

            // NOTE: migrations are not automatically executed for this service provider!
            // Still has to be done manually - see installAclMigrations()
            AuditTrailServiceProvider::class,
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
     * Paths
     ****************************************************************/

    /**
     * Returns path to configuration directory
     *
     * @return string
     */
    public function configDir(): string
    {
        return Configuration::dataDir() . 'configs/audit/';
    }

    /**
     * Returns paths to where database migrations are located
     *
     * @return string
     */
    public function packageMigrationsDir(): string
    {
        return __DIR__ . '/../../../packages/Audit/database/migrations';
    }

    /**
     * Returns paths to where tests migrations are located
     *
     * @return string
     */
    public function testsMigrationsDir(): string
    {
        return __DIR__ . '/../../_data/database/migrations';
    }

    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Runs the database migrations for the Audit package
     *
     * @return self
     */
    public function installAuditMigrations(): self
    {
        // Install default migrations
        $this->loadLaravelMigrations();

        // Install custom migrations
        $this->loadMigrationsFrom([
                $this->packageMigrationsDir(),
                $this->testsMigrationsDir()
        ]);

        return $this;
    }
}