<?php

namespace Aedart\Tests\Integration\Redmine\Resources;

use Aedart\Contracts\Redmine\Exceptions\UnsupportedOperationException;
use Aedart\Redmine\Issue;
use Aedart\Redmine\RedmineApiResource;
use Aedart\Tests\TestCases\Redmine\RedmineTestCase;
use Codeception\Attribute\Group;
use JsonException;
use PHPUnit\Framework\Attributes\Test;
use Throwable;

/**
 * IssueNotesTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Redmine\Resources
 */
#[Group(
    'redmine',
    'redmine-resources',
    'redmine-resources-issue-notes',
)]
class IssueNotesTest extends RedmineTestCase
{
    /**
     * @throws UnsupportedOperationException
     * @throws JsonException
     * @throws Throwable
     */
    #[Test]
    public function canAddNoteToIssue()
    {
        // Debug
        // RedmineApiResource::$debug = true;

        // ----------------------------------------------------------------------- //
        // Prerequisites
        $project = $this->createProject();

        $note = $this->getFaker()->text();

        $data = [
            'project_id' => $project->id(),
            'status_id' => 1,
            'tracker_id' => 1,
            'subject' => 'Issue via @aedart/athenaeum-redmine',
            'description' => 'Projects are been created via Redmine API Client, in [Athenaeum](https://github.com/aedart/athenaeum) package.'
        ];

        $changed = array_merge($data, [
            'journals' => [
                [
                    'id' => 1234,
                    'notes' => $note,
                    'created_on' => (string) now()
                ]
            ]
        ]);

        $connection = $this->liveOrMockedConnection([
            $this->mockCreatedResourceResponse($data, 1234, Issue::class),
            $this->mockUpdatedResourceResponse(),
            $this->mockReloadedResourceResponse($changed, 1234, Issue::class),
            $this->mockDeletedResourceResponse(),
        ]);

        $issue = Issue::create($data, [], $connection);

        // ----------------------------------------------------------------------- //
        // Add note

        $result = $issue
            ->withNote($note)
            ->withIncludes([ 'journals' ])
            ->save(true);

        $this->assertTrue($result, 'Issue was not updated');
        $this->assertNotEmpty($issue->journals, 'No journals returned');
        $this->assertCount(1, $issue->journals, 'Incorrect amount of journals');

        $entry = $issue->journals[0];
        $this->assertSame($note, $entry->notes, 'Incorrect note persisted');

        // ----------------------------------------------------------------------- //
        // Cleanup

        $issue->delete();

        // When testing locally, using a Sqlite database, the API request might be too soon after the first
        // project was deleted, which causes a "Database locked" exception / 500 Internal Server Error from
        // Redmine. To avoid this, we wait for ~250 ms.
        if ($this->isLive()) {
            usleep(250_000);
        }

        $project->delete();

        if ($this->isLive()) {
            usleep(150_000);
        }

        // Debug
        // RedmineApiResource::$debug = false;
    }
}
