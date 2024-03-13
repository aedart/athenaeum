<?php

namespace Aedart\Tests\Integration\Redmine\Resources;

use Aedart\Contracts\Redmine\Exceptions\UnsupportedOperationException;
use Aedart\Redmine\Issue;
use Aedart\Tests\TestCases\Redmine\RedmineTestCase;

/**
 * IssueNotesTest
 *
 * @group redmine
 * @group redmine-resources
 * @group redmine-resources-issue-notes
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Redmine\Resources
 */
class IssueNotesTest extends RedmineTestCase
{
    /**
     * @test
     *
     * @throws UnsupportedOperationException
     * @throws \JsonException
     * @throws \Throwable
     */
    public function canAddNoteToIssue()
    {
        // Debug
        //        Issue::$debug = true;

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
        $project->delete();
    }
}
