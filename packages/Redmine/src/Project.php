<?php

namespace Aedart\Redmine;

use Aedart\Contracts\Redmine\Creatable;
use Aedart\Contracts\Redmine\Deletable;
use Aedart\Contracts\Redmine\Listable;
use Aedart\Contracts\Redmine\Updatable;
use Aedart\Redmine\Partials\ListOfReferences;
use Aedart\Redmine\Partials\Reference;
use Aedart\Redmine\Relations\BelongsTo;
use Aedart\Redmine\Relations\Custom\ProjectIssueCategories;
use Aedart\Redmine\Relations\Custom\ProjectVersions;
use Aedart\Redmine\Relations\HasMany;
use Carbon\Carbon;
use JsonException;
use Throwable;

/**
 * Project Resource
 *
 * @see https://www.redmine.org/projects/redmine/wiki/Rest_Projects
 *
 * @property int $id
 * @property string $name
 * @property string $identifier
 * @property string $description
 * @property string $homepage
 * @property int $status
 * @property bool $is_public
 * @property Reference|null $parent
 * @property Reference|null $default_version
 * @property Reference|null $default_assignee
 * @property Carbon $created_on
 * @property Carbon $updated_on
 *
 * @property int|null $parent_id Property only available or expected when creating or updating resource.
 * @property bool|null $inherit_members Property only available or expected when creating or updating resource.
 * @property int|null $default_assigned_to_id Property only available or expected when creating or updating resource.
 * @property int|null $default_version_id Property only available or expected when creating or updating resource.
 * @property int[]|null $tracker_ids Property only available or expected when creating or updating resource.
 * @property string[]|null $enabled_module_names Property only available or expected when creating or updating resource.
 * @property int[]|null $issue_custom_field_ids Property only available or expected when creating or updating resource.
 *
 * @property ListOfReferences<Reference>|Reference[]|null $trackers Related data that can be requested included.
 * @property ListOfReferences<Reference>|Reference[]|null $issue_categories Related data that can be requested included.
 * @property ListOfReferences<Reference>|Reference[]|null $enabled_modules Related data that can be requested included.
 * @property ListOfReferences<Reference>|Reference[]|null $time_entry_activities Related data that can be requested included.
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Redmine
 */
class Project extends RedmineResource implements
    Listable,
    Creatable,
    Updatable,
    Deletable
{
    /**
     * Active project status
     *
     * @see https://www.redmine.org/projects/redmine/repository/entry/trunk/app/models/project.rb
     */
    public const STATUS_ACTIVE = 1;

    /**
     * Closed project status
     *
     * @see https://www.redmine.org/projects/redmine/repository/entry/trunk/app/models/project.rb
     */
    public const STATUS_CLOSED = 5;

    /**
     * Archived project status
     *
     * @see https://www.redmine.org/projects/redmine/repository/entry/trunk/app/models/project.rb
     */
    public const STATUS_ARCHIVED = 9;

    /**
     * List of available predefined statuses
     */
    public const STATUS_LIST = [
        self::STATUS_ACTIVE,
        self::STATUS_CLOSED,
        self::STATUS_ARCHIVED
    ];

    protected array $allowed = [
        'id' => 'int',
        'name' => 'string',
        'identifier' => 'string',
        'description' => 'string',
        'homepage' => 'string',
        'status' => 'int',
        'is_public' => 'bool',
        'parent' => Reference::class,
        'default_version' => Reference::class,
        'default_assignee' => Reference::class,
        'created_on' => 'date',
        'updated_on' => 'date',

        // Only when creating or updating
        'parent_id' => 'int',
        'inherit_members' => 'bool',
        'default_assigned_to_id' => 'int',
        'default_version_id' => 'int',
        'tracker_ids' => 'array',
        'enabled_module_names' => 'array',
        'issue_custom_field_ids' => 'array',

        // Related (can be included)
        'trackers' => ListOfReferences::class,
        'issue_categories' => ListOfReferences::class,
        'enabled_modules' => ListOfReferences::class,
        'time_entry_activities' => ListOfReferences::class,
    ];

    /**
     * @inheritDoc
     */
    public function resourceName(): string
    {
        return 'projects';
    }

    /**
     * Create a new version for this project
     *
     * @param array $data
     *
     * @return Version
     *
     * @throws JsonException
     * @throws Throwable
     */
    public function createVersion(array $data): Version
    {
        return Version::createForProject($this, $data, $this->getConnection());
    }

    /**
     * Create a new issue category for this project
     *
     * @param array $data
     *
     * @return IssueCategory
     *
     * @throws Throwable
     */
    public function createIssueCategory(array $data): IssueCategory
    {
        return IssueCategory::createForProject($this, $data, $this->getConnection());
    }

    /*****************************************************************
     * Relations
     ****************************************************************/

    /**
     * This project's parent project
     *
     * @return BelongsTo<static>
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(static::class, $this->parent);
    }

    /**
     * Issues that are owned by this project
     *
     * @return HasMany<Issue>
     */
    public function issues(): HasMany
    {
        return $this->hasMany(Issue::class);
    }

    /**
     * The default version of this project
     *
     * @return BelongsTo<Version>
     */
    public function defaultVersion(): BelongsTo
    {
        return $this->belongsTo(Version::class, $this->default_version);
    }

    /**
     * Versions belonging to this project
     *
     * @return HasMany<Version>
     */
    public function versions(): HasMany
    {
        return new ProjectVersions($this, Version::class);
    }

    /**
     * Issue categories used by this project
     *
     * @return HasMany<IssueCategory>
     */
    public function issueCategories(): HasMany
    {
        return new ProjectIssueCategories($this, IssueCategory::class);
    }

    // TODO: Assignee can also be a group! No way to tell what is return... ty Redmine!
//    /**
//     * The default assignee when issues are created in
//     * this project
//     *
//     * @return BelongsTo<User>
//     */
//    public function defaultAssignee(): BelongsTo
//    {
//        return $this->belongsTo(User::class, $this->default_assignee);
//    }
}
