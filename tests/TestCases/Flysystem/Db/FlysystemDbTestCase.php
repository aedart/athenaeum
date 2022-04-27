<?php

namespace Aedart\Tests\TestCases\Flysystem\Db;

use Aedart\Flysystem\Db\Providers\FlysystemDatabaseAdapterServiceProvider;
use Aedart\Support\Helpers\Filesystem\FileTrait;
use Aedart\Tests\TestCases\Flysystem\FlysystemTestCase;
use Codeception\Configuration;

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

    /*****************************************************************
     * Setup
     ****************************************************************/

    /**
     * @inheritDoc
     */
    protected function _before()
    {
        parent::_before();

        $fs = $this->getFile();
        $outputDir = $this->outputDir();

        $fs->ensureDirectoryExists($outputDir);
        $fs->cleanDirectory($outputDir);
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

    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Returns relative path to migrations directory
     *
     * @return string
     */
    public function migrationsPath(): string
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