<?php

namespace Aedart\Redmine;

use Aedart\Contracts\Redmine\Creatable;
use Aedart\Contracts\Redmine\Deletable;
use Aedart\Contracts\Redmine\Listable;
use Aedart\Contracts\Redmine\Updatable;
use Aedart\Redmine\Partials\Changeset;
use Aedart\Redmine\Partials\ChildIssueReference;
use Aedart\Redmine\Partials\CustomFieldReference;
use Aedart\Redmine\Partials\IssueParentReference;
use Aedart\Redmine\Partials\Journal;
use Aedart\Redmine\Partials\ListOfAttachments;
use Aedart\Redmine\Partials\ListOfChangesets;
use Aedart\Redmine\Partials\ListOfChildIssueReferences;
use Aedart\Redmine\Partials\ListOfCustomFieldReferences;
use Aedart\Redmine\Partials\ListOfJournals;
use Aedart\Redmine\Partials\ListOfReferences;
use Aedart\Redmine\Partials\ListOfRelatedIssues;
use Aedart\Redmine\Partials\Reference;
use Carbon\Carbon;

/**
 * Issue Resource
 *
 * @see https://www.redmine.org/projects/redmine/wiki/Rest_Issues
 *
 * @property int $id
 * @property Reference $project
 * @property Reference $tracker
 * @property Reference $status
 * @property Reference $priority
 * @property Reference $author
 * @property Reference|null $assigned_to
 * @property Reference|null $fixed_version
 * @property IssueParentReference|null $parent
 * @property string $subject
 * @property string $description
 * @property Carbon|null $start_date
 * @property Carbon|null $due_date
 * @property int $done_ratio
 * @property bool $is_private
 * @property float|null $estimated_hours
 * @property ListOfCustomFieldReferences<CustomFieldReference>|CustomFieldReference[]|null custom_fields
 * @property Carbon $created_on
 * @property Carbon $updated_on
 * @property Carbon|null $closed_on
 *
 * @property int $project_id Property only available or expected when creating or updating resource.
 * @property int $tracker_id Property only available or expected when creating or updating resource.
 * @property int $status_id Property only available or expected when creating or updating resource.
 * @property int $priority_id Property only available or expected when creating or updating resource.
 * @property int $category_id Property only available or expected when creating or updating resource.
 * @property int $fixed_version_id Property only available or expected when creating or updating resource.
 * @property int $assigned_to_id Property only available or expected when creating or updating resource.
 * @property int $parent_issue_id Property only available or expected when creating or updating resource.
 * @property int[] $watcher_user_ids Property only available or expected when creating or updating resource.
 *
 * @property ListOfAttachments<Attachment>|Attachment[]|null $attachments Related data that can be requested included.
 * @property ListOfChildIssueReferences<ChildIssueReference>|ChildIssueReference[]|null $children Related data that can be requested included.
 * @property ListOfRelatedIssues<Relation>|Relation[]|null $relations Related data that can be requested included.
 * @property ListOfChangesets<Changeset>|Changeset[]|null $changesets Related data that can be requested included.
 * @property ListOfJournals<Journal>|Journal[]|null $journals Related data that can be requested included.
 * @property ListOfReferences<Reference>|Reference[]|null $watchers Related data that can be requested included.
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Redmine
 */
class Issue extends RedmineResource implements
    Listable,
    Creatable,
    Updatable,
    Deletable
{
    protected array $allowed = [
        'id' => 'int',
        'project' => Reference::class,
        'tracker' => Reference::class,
        'status' => Reference::class,
        'priority' => Reference::class,
        'author' => Reference::class,
        'assigned_to' => Reference::class,
        'fixed_version' => Reference::class,
        'parent' => IssueParentReference::class,
        'subject' => 'string',
        'description' => 'string',
        'start_date' => 'date',
        'due_date' => 'date',
        'done_ratio' => 'int',
        'is_private' => 'bool',
        'estimated_hours' => 'float',
        'custom_fields' => ListOfCustomFieldReferences::class,
        'created_on' => 'date',
        'updated_on' => 'date',
        'closed_on' => 'date',

        // Only when creating or updating
        'project_id' => 'int',
        'tracker_id' => 'int',
        'status_id' => 'int',
        'priority_id' => 'int',
        'category_id' => 'int',
        'fixed_version_id' => 'int',
        'assigned_to_id' => 'int',
        'parent_issue_id' => 'int',
        'watcher_user_ids' => 'array',

        // Related (can be included)
        'attachments' => ListOfAttachments::class,
        'children' => ListOfChildIssueReferences::class,
        'relations' => ListOfRelatedIssues::class,
        'changesets' => ListOfChangesets::class,
        'journals' => ListOfJournals::class,
        'watchers' => ListOfReferences::class,
    ];

    /**
     * @inheritDoc
     */
    public function resourceName(): string
    {
        return 'issues';
    }
}
