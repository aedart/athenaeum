<?php

namespace Aedart\Tests\Integration\Redmine\Resources;

use Aedart\Redmine\Attachment;
use Aedart\Redmine\Issue;
use Aedart\Tests\TestCases\Redmine\RedmineTestCase;
use Codeception\Attribute\Group;
use JsonException;
use PHPUnit\Framework\Attributes\Test;
use Throwable;

/**
 * IssueAttachmentsTest
 *
 * @group redmine
 * @group redmine-resources
 * @group redmine-resources-issue-attachments
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Redmine\Resources
 */
#[Group(
    'redmine',
    'redmine-resources',
    'redmine-resources-issue-attachments',
)]
class IssueAttachmentsTest extends RedmineTestCase
{
    /**
     * @test
     *
     * @throws JsonException
     * @throws Throwable
     */
    #[Test]
    public function canCreateIssueWithAttachments()
    {
        // Debug
        //        Issue::$debug = true;

        // ----------------------------------------------------------------------- //
        // Prerequisites
        $project = $this->createProject();

        // ----------------------------------------------------------------------- //
        // Upload two files

        $fileA = $this->dummyFile();
        $fileB = $this->dummyFile();
        $fileData = [
            'filename' => basename($fileA),
            'filesize' => filesize($fileA),
            'content_type' => 'text/plain',
        ];

        $desc = 'Disconnection, ionic cannon, and nuclear flux.';

        $connectionA = $this->liveOrMockedConnection([
            $this->mockUploadedResponse(),
            $this->mockReloadedResourceResponse($fileData, 1234, Attachment::class),
            $this->mockDeletedResourceResponse()
        ]);

        $connectionB = $this->liveOrMockedConnection([
            $this->mockUploadedResponse(),
            $this->mockReloadedResourceResponse($fileData, 4567, Attachment::class),
            $this->mockDeletedResourceResponse()
        ]);

        $attachmentA = Attachment::upload($fileA, true, $connectionA);
        $attachmentB = Attachment::upload($fileB, true, $connectionB);

        $this->assertTrue($attachmentA->hasToken(), 'attachment a has no token');
        $this->assertTrue($attachmentB->hasToken(), 'attachment b has no token');

        // ----------------------------------------------------------------------- //
        // Create issue with attachments

        $issueData = [
            'project_id' => $project->id(),
            'status_id' => 1,
            'tracker_id' => 1,
            'subject' => 'Issue with Attachments via @aedart/athenaeum-redmine',
            'description' => 'Projects are been created via Redmine API Client, in [Athenaeum](https://github.com/aedart/athenaeum) package.',
            'attachments' => [
                array_merge($fileData, [
                    'id' => 1234,
                    'description' => $desc,
                    'created_on' => (string) now(),
                    'author' => [
                        'id' => 1324,
                        'name' => 'Timmy'
                    ]
                ]),
                array_merge($fileData, [
                    'id' => 4567,
                    'description' => $desc,
                    'created_on' => (string) now(),
                    'author' => [
                        'id' => 1324,
                        'name' => 'Timmy'
                    ]
                ]),
            ]
        ];

        $connectionC = $this->liveOrMockedConnection([
            $this->mockCreatedResourceResponse($issueData, 1234, Issue::class),
            $this->mockDeletedResourceResponse(),
        ]);

        // Set attachments descriptions
        $attachmentA->description = $desc;
        $attachmentB->description = $desc;

        // Create the issue
        $issue = Issue::createWithAttachments($issueData, [
            $attachmentA,
            $attachmentB
        ], [], $connectionC);

        $this->assertNotEmpty($issue->id(), 'Issue was not created');
        $this->assertNotEmpty($issue->attachments, 'No attachments returned on issue');
        $this->assertCount(2, $issue->attachments, 'Incorrect amount of attachments associated with issue');

        // Ensure that filenames are as expected (not that important)
        foreach ($issue->attachments as $att) {
            $this->assertSame($fileData['filename'], $att->filename);
            $this->assertSame($desc, $att->description);
        }

        // ----------------------------------------------------------------------- //
        // Cleanup

        $attachmentA->delete();
        $attachmentB->delete();
        $issue->delete();

        // When testing locally, using a Sqlite database, the API request might be too soon after the first
        // project was deleted, which causes a "Database locked" exception / 500 Internal Server Error from
        // Redmine. To avoid this, we wait for ~250 ms.
        if ($this->isLive()) {
            usleep(250_000);
        }

        $project->delete();

        if ($this->isLive()) {
            usleep(250_000);
        }
    }
}
