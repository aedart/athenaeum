<?php

namespace Aedart\Tests\Integration\Redmine\Resources;

use Aedart\Contracts\Http\Clients\Exceptions\InvalidUriException;
use Aedart\Contracts\Redmine\Exceptions\UnsupportedOperationException;
use Aedart\Redmine\Attachment;
use Aedart\Tests\TestCases\Redmine\RedmineTestCase;
use Codeception\Exception\ConfigurationException;
use InvalidArgumentException;
use RuntimeException;

/**
 * AttachmentTest
 *
 * @group redmine
 * @group redmine-resources
 * @group redmine-resources-attachment
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Redmine\Resources
 */
class AttachmentTest extends RedmineTestCase
{
    /**
     * @test
     *
     * @throws \JsonException
     * @throws \Throwable
     */
    public function failsIfFileDoesNotExist()
    {
        $this->expectException(InvalidArgumentException::class);

        $file = '/temp/some-file-that-does-not-exist.txt';

        Attachment::upload($file);
    }

    /**
     * @test
     *
     * @throws \JsonException
     * @throws \Throwable
     */
    public function canUploadAFile()
    {
        // Debug
        //        Attachment::$debug = true;

        $file = $this->dummyFile();

        $data = [
            'filename' => basename($file),
            'filesize' => filesize($file),
            'content_type' => 'text/plain',
        ];

        // ---------------------------------------------------------- //

        $connection = $this->liveOrMockedConnection([
            $this->mockUploadedResponse(),
            $this->mockReloadedResourceResponse($data, 1234, Attachment::class),
            $this->mockDeletedResourceResponse()
        ]);

        // ---------------------------------------------------------- //
        // Upload file

        $attachment = Attachment::upload($file, true, $connection);

        $this->assertNotEmpty($attachment->id, 'No id was returned');
        $this->assertNotEmpty($attachment->token, 'No token was returned!');

        // ---------------------------------------------------------- //
        // Cleanup

        $attachment->delete();
    }

    /**
     * @test
     *
     * @throws ConfigurationException
     * @throws InvalidUriException
     * @throws UnsupportedOperationException
     * @throws \JsonException
     * @throws \Throwable
     */
    public function canDownloadFile()
    {
        // Debug
        //        Attachment::$debug = true;

        $file = $this->dummyFile();

        $data = [
            'filename' => basename($file),
            'filesize' => filesize($file),
            'content_type' => 'text/plain',
            'content_url' => 'https://your-redmine-instance.com' // Url does not matter here...
        ];

        // ---------------------------------------------------------- //

        $connection = $this->liveOrMockedConnection([
            $this->mockUploadedResponse(),
            $this->mockReloadedResourceResponse($data, 1234, Attachment::class),
            $this->mockDownloadFileResponse($file, $data['content_type']),
            $this->mockDeletedResourceResponse()
        ]);

        // ---------------------------------------------------------- //
        // Prerequisite

        $attachment = Attachment::upload($file, true, $connection);

        $this->assertNotEmpty($attachment->id, 'No id was returned');

        // ---------------------------------------------------------- //
        // Download

        $dir = $this->downloadDir();
        $attachment->download($dir);

        $expected = $dir . DIRECTORY_SEPARATOR . $attachment->filename;
        $this->assertFileExists($expected);
        $this->assertSame(file_get_contents($file), file_get_contents($expected), 'Incorrect file downloaded');

        // ---------------------------------------------------------- //
        // Cleanup

        $attachment->delete();
    }

    /**
     * @test
     *
     * @throws InvalidUriException
     * @throws ConfigurationException
     * @throws \Throwable
     */
    public function failDownloadWhenNoContentUrlSpecified()
    {
        $this->expectException(RuntimeException::class);

        Attachment::make()->download($this->downloadDir());
    }

    /**
     * @test
     *
     * @throws InvalidUriException
     * @throws ConfigurationException
     * @throws \Throwable
     */
    public function failDownloadWhenDirectoryIsInvalid()
    {
        $this->expectException(InvalidArgumentException::class);

        Attachment::make([ 'content_url' => 'https://your-redmine.com' ])->download('/temp/path-to-unknown-directory');
    }
}
