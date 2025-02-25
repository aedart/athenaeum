<?php

namespace Aedart\Tests\TestCases\Support;

use Aedart\Support\Helpers\Filesystem\FileTrait;
use Aedart\Testing\TestCases\LaravelTestCase;
use Codeception\Configuration;
use Codeception\Exception\ConfigurationException;

/**
 * Env File Test Case
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\TestCases\Support
 */
abstract class EnvFileTestCase extends LaravelTestCase
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

        // Clean some directories
        $fs = $this->getFile();
        $outputDir = $this->outputDir();

        $fs->ensureDirectoryExists($outputDir);
        $fs->cleanDirectory($outputDir);

        // Copy existing .env file into output dir.
        $fs->copy(getcwd() . '/.testing.example', $this->envFilePath());
    }

    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Returns path to output directory
     *
     * @return string
     *
     * @throws ConfigurationException
     */
    public function outputDir(): string
    {
        return Configuration::outputDir() . 'support/env';
    }

    /**
     * Returns path to environment file
     *
     * @return string
     *
     * @throws ConfigurationException
     */
    public function envFilePath(): string
    {
        return $this->outputDir() . '/.env';
    }
}
