<?php

namespace Aedart\Tests\Integration\Redmine\Resources;

use Aedart\Contracts\Http\Clients\Exceptions\InvalidUriException;
use Aedart\Contracts\Redmine\Exceptions\UnsupportedOperationException;
use Aedart\Redmine\Attachment;
use Aedart\Tests\TestCases\Redmine\RedmineTestCase;
use Codeception\Attribute\Group;
use Codeception\Exception\ConfigurationException;
use InvalidArgumentException;
use JsonException;
use PHPUnit\Framework\Attributes\Test;
use RuntimeException;
use Throwable;

/**
 * AttachmentTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Redmine\Resources
 */
#[Group(
    'redmine',
    'redmine-resources',
    'redmine-resources-attachment',
)]
class AttachmentTest extends RedmineTestCase
{
    /**
     * @throws JsonException
     * @throws Throwable
     */
    #[Test]
    public function failsIfFileDoesNotExist()
    {
        $this->expectException(InvalidArgumentException::class);

        $file = '/temp/some-file-that-does-not-exist.txt';

        Attachment::upload($file);
    }

    /**
     * @throws JsonException
     * @throws Throwable
     */
    #[Test]
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
     * @throws ConfigurationException
     * @throws InvalidUriException
     * @throws UnsupportedOperationException
     * @throws JsonException
     * @throws Throwable
     */
    #[Test]
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
     * @throws InvalidUriException
     * @throws ConfigurationException
     * @throws Throwable
     */
    #[Test]
    public function failDownloadWhenNoContentUrlSpecified()
    {
        $this->expectException(RuntimeException::class);

        Attachment::make()->download($this->downloadDir());
    }

    /**
     * @throws InvalidUriException
     * @throws ConfigurationException
     * @throws Throwable
     */
    #[Test]
    public function failDownloadWhenDirectoryIsInvalid()
    {
        $this->expectException(InvalidArgumentException::class);

        Attachment::make([ 'content_url' => 'https://your-redmine.com' ])->download('/temp/path-to-unknown-directory');
    }
}
