<?php

namespace Aedart\Tests\TestCases\Flysystem\Db;

use Aedart\Flysystem\Db\Providers\FlysystemDatabaseAdapterServiceProvider;
use Aedart\Support\Helpers\Filesystem\FileTrait;
use Aedart\Tests\TestCases\Flysystem\FlysystemTestCase;
use Codeception\Configuration;
use Tests\Integration\Packages\Filesystem\AdapterTestCase;

/**
 * Flysystem Db Test Case
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\TestCases\Flysystem\Db
 */
abstract class FlysystemDbTestCase extends FlysystemTestCase
{
    use FileTrait;

    /**
     * Name of the console command
     */
    public const MAKE_MIGRATION_CMD = 'flysystem:make-adapter-migration';

    /**
     * State whether migrations should be installed or not
     *
     * @var bool
     */
    protected bool $installAdapterMigrations = true;

    /*****************************************************************
     * Setup
     ****************************************************************/

    /**
     * @inheritDoc
     */
    protected function _before()
    {
        parent::_before();

        // Clean some directories
        $fs = $this->getFile();
        $outputDir = $this->outputDir();

        $fs->ensureDirectoryExists($outputDir);
        $fs->cleanDirectory($outputDir);

        // Run migrations
        if ($this->installAdapterMigrations) {
            $this->installFilesystemMigrations();
        }
    }

    /**
     * @inheritdoc
     */
    protected function _after()
    {
        parent::_after();
    }

    /**
     * @inheritdoc
     */
    protected function getEnvironmentSetUp($app)
    {
        // For these tests we will run against a sqlite in-memory database,
        // so that we can safely clean up everything afterwards.
        // NOTE: Configuration from orchestra test bench-core is used here!
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing.foreign_key_constraints', true);
    }

    /**
     * {@inheritdoc}
     */
    protected function getPackageProviders($app)
    {
        return [
            FlysystemDatabaseAdapterServiceProvider::class
        ];
    }

    /**
     * Runs the database migrations for the filesystem package
     *
     * @return self
     */
    public function installFilesystemMigrations(): self
    {
        // Install default migrations
        $this->loadLaravelMigrations();

        // Install custom migrations
        $this->loadMigrationsFrom(
            [
                '--path' => $this->migrations(),
                '--realpath' => true
            ]
        );

        return $this;
    }

    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Returns paths to where database migrations are located
     *
     * @return string
     */
    public function migrations(): string
    {
        return Configuration::dataDir() . 'flysystem/db/migrations';
    }

    /**
     * Returns relative path to migrations directory
     *
     * @return string
     */
    public function migrationsOutputPath(): string
    {
        // Note: path is relative to the 'vendor/orchestra/testbench-core/laravel/' directory!
        // This is needed for the "make adapter migration" command. Current version does not
        // support real-path!
        return '../../../../tests/_output/flysystem/db';
    }

    /**
     * Returns path to output directory
     *
     * @return string
     *
     * @throws \Codeception\Exception\ConfigurationException
     */
    public function outputDir(): string
    {
        return Configuration::outputDir() . 'flysystem/db';
    }
}