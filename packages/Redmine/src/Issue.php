<?php

namespace Aedart\Redmine;

use Aedart\Contracts\Redmine\Connection;
use Aedart\Contracts\Redmine\Creatable;
use Aedart\Contracts\Redmine\Deletable;
use Aedart\Contracts\Redmine\Exceptions\RedmineException;
use Aedart\Contracts\Redmine\Exceptions\UnsupportedOperationException;
use Aedart\Contracts\Redmine\Listable;
use Aedart\Contracts\Redmine\Updatable;
use Aedart\Redmine\Attachments\PendingAttachment;
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
use Aedart\Redmine\Relations\BelongsTo;
use Aedart\Redmine\Relations\OneFromList;
use Carbon\Carbon;
use InvalidArgumentException;
use JsonException;
use RuntimeException;
use Throwable;

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
 * @property Reference|null $category
 * @property Reference|null $fixed_version
 * @property IssueParentReference|null $parent
 * @property string $subject
 * @property string $description
 * @property Carbon|null $start_date
 * @property Carbon|null $due_date
 * @property int $done_ratio
 * @property bool $is_private
 * @property float|null $estimated_hours
 * @property float|null $total_estimated_hours
 * @property float|null $spent_hours
 * @property float|null $total_spent_hours
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
 * @property array $uploads Property only available or expected when creating or updating resource.
 * @property string $notes Property only available or expected when creating or updating resource.
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
        'category' => Reference::class,
        'fixed_version' => Reference::class,
        'parent' => IssueParentReference::class,
        'subject' => 'string',
        'description' => 'string',
        'start_date' => 'date',
        'due_date' => 'date',
        'done_ratio' => 'int',
        'is_private' => 'bool',
        'estimated_hours' => 'float',
        'total_estimated_hours' => 'float',
        'spent_hours' => 'float',
        'total_spent_hours' => 'float',
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
        'uploads' => 'array',
        'notes' => 'string',

        // Related (can be included)
        'attachments' => ListOfAttachments::class,
        'children' => ListOfChildIssueReferences::class,
        'relations' => ListOfRelatedIssues::class,
        'changesets' => ListOfChangesets::class,
        'journals' => ListOfJournals::class,
        'watchers' => ListOfReferences::class,
    ];

    /**
     * List of pending attachments to be associated
     * with this Issue.
     *
     * @var PendingAttachment[]
     */
    protected array $pendingAttachments = [];

    /**
     * @inheritDoc
     */
    public function resourceName(): string
    {
        return 'issues';
    }

    /*****************************************************************
     * Attachments
     ****************************************************************/

    /**
     * Create a new issue with given attachments
     *
     * @param array $data
     * @param Attachment[] $attachments
     * @param string[] $include [optional] List of associated data to include
     * @param string|Connection|null $connection [optional] Redmine connection profile
     *
     * @return static
     *
     * @throws RedmineException
     * @throws UnsupportedOperationException
     * @throws JsonException
     * @throws Throwable
     */
    public static function createWithAttachments(
        array $data,
        array $attachments,
        array $include = [],
        $connection = null
    ) {
        $resource = static::make($data, $connection);

        // Ensure that "attachments" are automatically included,
        // if not already requested.
        $include = array_merge($include, [ 'attachments' ]);

        // Create new issue
        $resource
            ->withAttachments($attachments)
            ->withIncludes($include)
            ->save();

        return $resource;
    }

    /**
     * Associate attachment with this resource
     *
     * Note: Method does not perform request, you must invoke
     * {@see save()} before association takes effect.
     *
     * @param Attachment $attachment
     *
     * @return self
     *
     * @throws InvalidArgumentException If attachment does not have a token or id
     */
    public function withAttachment(Attachment $attachment): self
    {
        $this->pendingAttachments[] = PendingAttachment::make($attachment);

        return $this;
    }

    /**
     * Associate multiple attachments with this resource
     *
     * Note: Method does not perform request, you must invoke
     * {@see save()} before association takes effect.
     *
     * @see withAttachment
     *
     * @param Attachment[] $attachments
     *
     * @return self
     *
     * @throws InvalidArgumentException If attachment does not have a token or id
     */
    public function withAttachments(array $attachments): self
    {
        foreach ($attachments as $attachment) {
            $this->withAttachment($attachment);
        }

        return $this;
    }

    /**
     * Prepare the attachments in given payload data
     *
     * @param array $data Payload data
     *
     * @return array Payload with attachments
     */
    protected function prepareAttachments(array $data): array
    {
        // List of attachment to associate with this resources
        $uploads = [];

        foreach ($this->pendingAttachments as $pending) {
            $uploads[] = $pending->toArray();
        }

        // Assign to payload
        $data['uploads'] = $uploads;

        // Clear pending attachments
        $this->pendingAttachments = [];

        return $data;
    }

    /*****************************************************************
     * Notes (Journal)
     ****************************************************************/

    /**
     * Add a note to be this issue
     *
     * Note: Method does not perform request, you must invoke
     * {@see save()} before note is persisted.
     *
     * To include notes in issue, you must include "journals"
     *
     * @param string $note
     *
     * @return self
     */
    public function withNote(string $note): self
    {
        $this->properties['notes'] = $note;

        return $this;
    }

    /*****************************************************************
     * Issue Relations
     ****************************************************************/

    /**
     * Add a new relation for this issue
     *
     * @param int|Issue $related Related Issue id or instance
     * @param string $type [optional] Type of relation
     * @param float|null $delay [optional] The delay (days) for a "precedes" or "follows" relation
     *
     * @return Relation
     *
     * @throws InvalidArgumentException If related argument is invalid
     * @throws RuntimeException If this issue (parent) does not exist
     * @throws JsonException
     * @throws Throwable
     */
    public function addRelation($related, string $type = Relation::RELATES, ?float $delay = null): Relation
    {
        $relatedId = $related;
        if ($related instanceof self) {
            $relatedId = $related->id();
        }

        if (!is_int($relatedId)) {
            throw new InvalidArgumentException('Invalid related argument. Expected id or Issue instance');
        }

        if (!$this->exists()) {
            throw new RuntimeException('Unable to relate to Issue; parent issue has no id specified');
        }

        return Relation::createRelation(
            $this->id(),
            $relatedId,
            $type,
            $delay,
            $this->getConnection()
        );
    }

    /*****************************************************************
     * Relations
     ****************************************************************/

    /**
     * The project this issue belongs to
     *
     * @return BelongsTo<Project>
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, $this->project);
    }

    /**
     * The tracker used by this issue (the type of issue)
     *
     * @return OneFromList<Tracker>
     */
    public function tracker(): OneFromList
    {
        return $this->oneFrom(Tracker::class, $this->tracker);
    }

    /**
     * This issue's status
     *
     * @return OneFromList<IssueStatus>
     */
    public function status(): OneFromList
    {
        return $this->oneFrom(IssueStatus::class, $this->status);
    }

    /**
     * This issue's priority
     *
     * @return OneFromList<IssuePriority>
     */
    public function priority(): OneFromList
    {
        return $this->oneFrom(IssuePriority::class, $this->priority);
    }

    /**
     * This issue's parent issue
     *
     * @return BelongsTo<static>
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(static::class, $this->parent);
    }

    /**
     * The author (user) of this issue
     *
     * @return BelongsTo<User>
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, $this->author);
    }

    /**
     * The category assigned to this issue
     *
     * @return BelongsTo<IssueCategory>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(IssueCategory::class, $this->category);
    }

    /**
     * The version this issue has been assigned to
     *
     * @return BelongsTo<Version>
     */
    public function fixedVersion(): BelongsTo
    {
        return $this->belongsTo(Version::class, $this->fixed_version);
    }

    // TODO: Assignee can also be a group! No way to tell what is return... ty Redmine!

    /*****************************************************************
     * Utils
     ****************************************************************/

    /**
     * @inheritDoc
     */
    public function prepareBeforeCreate(array $data): array
    {
        return $this->prepareAttachments(
            $this->prepareDates($data)
        );
    }

    /**
     * @inheritDoc
     */
    public function prepareBeforeUpdate(array $data): array
    {
        return $this->prepareAttachments(
            $this->prepareDates($data)
        );
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Formats some data fields
     *
     * @param array $data
     *
     * @return array
     */
    protected function prepareDates(array $data): array
    {
        return $this->formatDateFields(['start_date', 'due_date'], $data, 'Y-m-d');
    }
}
