<?php

namespace Aedart\Tests\TestCases\MimeTypes;

use Aedart\Config\Providers\ConfigLoaderServiceProvider;
use Aedart\Config\Traits\ConfigLoaderTrait;
use Aedart\Contracts\MimeTypes\Exceptions\MimeTypeDetectionException;
use Aedart\Contracts\MimeTypes\MimeType;
use Aedart\MimeTypes\Concerns\MimeTypeDetection;
use Aedart\MimeTypes\Providers\MimeTypesDetectionServiceProvider;
use Aedart\Support\Helpers\Config\ConfigTrait;
use Aedart\Testing\TestCases\LaravelTestCase;
use Codeception\Configuration;

/**
 * Mime-Types Test-Case
 *
 * Base test case for the mime-types package components
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\TestCases\MimeTypes
 */
abstract class MimeTypesTestCase extends LaravelTestCase
{
    use ConfigLoaderTrait;
    use ConfigTrait;
    use MimeTypeDetection;

    /**
     * Mime-Type data to be sampled
     *
     * @var string|resource|null
     */
    protected $mimeTypeData = null;

    /**
     * @test
     *
     * @var resource|null
     */
    protected $fileStream = null;

    /*****************************************************************
     * Setup
     ****************************************************************/

    /**
     * {@inheritdoc}
     *
     * @throws \Aedart\Contracts\Config\Loaders\Exceptions\InvalidPathException
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
    protected function _after()
    {
        if (isset($this->fileStream) && is_resource($this->fileStream)) {
            fclose($this->fileStream);
        }

        parent::_after();
    }

    /**
     * {@inheritdoc}
     */
    protected function getPackageProviders($app)
    {
        return [
            ConfigLoaderServiceProvider::class,
            MimeTypesDetectionServiceProvider::class
        ];
    }

    /**
     * Returns the path to configuration files
     *
     * @return string
     */
    public function configDir(): string
    {
        return Configuration::dataDir() . 'configs/mime-types';
    }

    /**
     * Returns path to test files
     *
     * @return string
     */
    public function filesDir(): string
    {
        return Configuration::dataDir() . 'mime-types/files';
    }

    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Set the file data to be sampled for mime-type
     *
     * @param string|resource $data
     *
     * @return self
     */
    public function withMimeTypeData($data): static
    {
        $this->mimeTypeData = $data;

        return $this;
    }

    /**
     * @inheritDoc
     */
    protected function mimeTypeData()
    {
        return $this->mimeTypeData;
    }

    /**
     * Returns mime-type using string content
     *
     * @param  string  $ext File extension
     * @param  string  $profile
     * @param  array  $options  [optional]
     *
     * @return MimeType
     * @throws MimeTypeDetectionException
     */
    protected function mimeTypeUsingStringContent(string $ext, string $profile, array $options = []): MimeType
    {
        return $this
            ->withMimeTypeData($this->getFileContents($ext))
            ->mimeType($profile, $options);
    }

    /**
     * Returns mime-type using file stream
     *
     * @param  string  $ext File extension
     * @param  string  $profile
     * @param  array  $options  [optional]
     *
     * @return MimeType
     * @throws MimeTypeDetectionException
     */
    protected function mimeTypeUsingStream(string $ext, string $profile, array $options = []): MimeType
    {
        return $this
            ->withMimeTypeData($this->getFileStream($ext))
            ->mimeType($profile, $options);
    }

    /**
     * Returns path to test file
     *
     * @param  string  $ext File extension
     *
     * @return string
     */
    public function filePath(string $ext): string
    {
        return $this->filesDir() . DIRECTORY_SEPARATOR . "test.{$ext}";
    }

    /**
     * Returns test file contents
     *
     * @param  string  $ext File extension
     *
     * @return string
     */
    public function getFileContents(string $ext): string
    {
        $path = $this->filePath($ext);

        return file_get_contents($path);
    }

    /**
     * Returns test file stream
     *
     * @param  string  $ext
     *
     * @return false|resource
     */
    public function getFileStream(string $ext)
    {
        $path = $this->filePath($ext);

        return $this->fileStream = fopen($path, 'r+b');
    }

    /**
     * Creates a new test file expectation
     *
     * @param  string  $ext
     * @param  string  $type
     * @param  string  $encoding
     * @param  array  $extensions  [optional]
     *
     * @return array
     */
    public function makeTestFileExpectation(
        string $ext,
        string $type,
        string $encoding,
        array $extensions = []
    ): array
    {
        return [[
            $ext,
            $type,
            $encoding,
            $extensions
        ]];
    }
}
