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