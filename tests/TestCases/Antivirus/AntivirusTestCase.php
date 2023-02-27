<?php

namespace Aedart\Tests\TestCases\Antivirus;

use Aedart\Antivirus\Providers\AntivirusServiceProvider;
use Aedart\Antivirus\Traits\AntivirusManagerTrait;
use Aedart\Config\Providers\ConfigLoaderServiceProvider;
use Aedart\Config\Traits\ConfigLoaderTrait;
use Aedart\Contracts\Antivirus\Exceptions\ProfileNotFoundException;
use Aedart\Contracts\Antivirus\Scanner;
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

    /**
     * Returns path to where dummy files are located
     *
     * @return string
     */
    public function dataDir(): string
    {
        return Configuration::dataDir() . 'antivirus';
    }

    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Returns a scanner instance that matches given profile
     *
     * @param string|null $profile [optional]
     * @param array $options [optional]
     *
     * @return Scanner
     *
     * @throws ProfileNotFoundException
     */
    public function makeScanner(string|null $profile = null, array $options = []): Scanner
    {
        return $this->getAntivirusManager()->profile($profile, $options);
    }

    /**
     * Returns a full path to given file
     *
     * @param string $file Filename with extension
     *
     * @return string
     */
    public function filePath(string $file): string
    {
        return $this->dataDir() . '/' . $file;
    }

    /**
     * Returns path to a clean test file
     *
     * @return string
     */
    public function cleanFile(): string
    {
        return $this->filePath('clean.txt');
    }

    /**
     * Returns path to an infected test file
     *
     * @return string
     */
    public function infectedFile(): string
    {
        return $this->filePath('stdInfectedFile.txt');
    }

    /**
     * Returns path to an infected test file that is compressed
     *
     * @return string
     */
    public function compressedInfectedFile(): string
    {
        return $this->filePath('stdInfectedFile.tar.xz');
    }
}
