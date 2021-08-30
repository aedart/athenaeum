<?php

namespace Aedart\Tests\Integration\Redmine\Resources;

use Aedart\Redmine\Attachment;
use Aedart\Tests\TestCases\Redmine\RedmineTestCase;
use InvalidArgumentException;

/**
 * AttachmentTest
 *
 * @group redmine
 * @group redmine-resources
 * @group redmine-resources-attachment
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
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
}
