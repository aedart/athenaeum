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
     *
     * @return array
     */
    public function makeTestFileExpectation(
        string $ext,
        string $type,
        string $encoding
    ): array {
        return [[
            $ext,
            $type,
            $encoding
        ]];
    }

    /*****************************************************************
     * Data Providers
     ****************************************************************/

    /**
     * Provides test files
     *
     * @return array
     */
    public function testFiles(): array
    {
        // Lookup mime types / content types:
        //
        // @see https://svn.apache.org/repos/asf/httpd/httpd/trunk/docs/conf/mime.types
        // @see https://fileinfo.com/

        $output = [
            '7z' => $this->makeTestFileExpectation(
                '7z',
                'application/x-7z-compressed',
                'binary'
            ),
            'doc' => $this->makeTestFileExpectation(
                'doc',
                'application/msword',
                'binary'
            ),
            'docx' => $this->makeTestFileExpectation(
                'docx',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'binary'
            ),
            // TODO: failure - Maybe wrong sample file?
//            'dotx' => $this->makeTestFileExpectation(
//                'dotx',
//                'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
//                'binary'
//            ),
            'jpg' => $this->makeTestFileExpectation(
                'jpg',
                'image/jpeg',
                'binary'
            ),
            'pdf' => $this->makeTestFileExpectation(
                'pdf',
                'application/pdf',
                'binary'
            ),
            'png' => $this->makeTestFileExpectation(
                'png',
                'image/png',
                'binary'
            ),
            'rtf' => $this->makeTestFileExpectation(
                'rtf',
                'text/rtf',
                'us-ascii'
            ),
            'tar.xz' => $this->makeTestFileExpectation(
                'tar.xz',
                'application/x-xz',
                'binary'
            ),
            'txt' => $this->makeTestFileExpectation(
                'txt',
                'text/plain',
                'us-ascii'
            ),
            'xls' => $this->makeTestFileExpectation(
                'xls',
                'application/vnd.ms-excel',
                'binary'
            ),
            'xlsx' => $this->makeTestFileExpectation(
                'xlsx',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'binary'
            ),
            'zip' => $this->makeTestFileExpectation(
                'zip',
                'application/zip',
                'binary'
            ),
        ];

        return $output;
    }
}
