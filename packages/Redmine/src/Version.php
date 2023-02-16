<?php

namespace Aedart\Redmine;

use Aedart\Contracts\Redmine\Deletable;
use Aedart\Contracts\Redmine\Updatable;
use Aedart\Redmine\Partials\Reference;
use Aedart\Redmine\Relations\BelongsTo;
use Aedart\Redmine\Relations\HasMany;
use Carbon\Carbon;

/**
 * Version Resource
 *
 * **Note**: _The Version resource is tight up to {@see \Aedart\Redmine\Project} resources. You can only
 * list and create versions via specialised methods._
 *
 * @see https://www.redmine.org/projects/redmine/wiki/Rest_Versions
 *
 * @property int $id
 * @property Reference $project
 * @property string $name
 * @property string $description
 * @property string $status
 * @property Carbon $due_date
 * @property string $sharing
 * @property string $wiki_page_title
 * @property Carbon $created_on
 * @property Carbon $updated_on
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Redmine
 */
class Version extends RedmineApiResource implements
    Updatable,
    Deletable
{
    use Concerns\ProjectDependentResource;

    /**
     * Open - version status (default)
     */
    public const STATUS_OPEN = 'open';

    /**
     * Locked - version status
     */
    public const STATUS_LOCKED = 'locked';

    /**
     * Closed - version status
     */
    public const STATUS_CLOSED = 'closed';

    /**
     * List of predefined version status
     */
    public const STATUS_LIST = [
        self::STATUS_OPEN,
        self::STATUS_LOCKED,
        self::STATUS_CLOSED,
    ];

    /**
     * Version is shared with no other projects (default)
     */
    public const SHARED_WITH_NONE = 'none';

    /**
     * Version is shared owning project's sub-projects
     */
    public const SHARED_WITH_SUB_PROJECTS = 'descendants';

    /**
     * Version is shared project hierarchy
     */
    public const SHARED_WITH_PROJECT_HIERARCHY = 'hierarchy';

    /**
     * Version is shared with project tree
     */
    public const SHARED_WITH_PROJECT_TREE = 'tree';

    /**
     * Version is shared with all projects
     */
    public const SHARED_WITH_ALL = 'system';

    /**
     * List of predefined "shared with" state
     */
    public const SHARED_WITH_LIST = [
        self::SHARED_WITH_NONE,
        self::SHARED_WITH_SUB_PROJECTS,
        self::SHARED_WITH_PROJECT_HIERARCHY,
        self::SHARED_WITH_PROJECT_TREE,
        self::SHARED_WITH_ALL,
    ];

    protected array $allowed = [
        'id' => 'int',
        'project' => Reference::class,
        'name' => 'string',
        'description' => 'string',
        'status' => 'string',
        'due_date' => 'date',
        'sharing' => 'string',
        'wiki_page_title' => 'string',
        'created_on' => 'date',
        'updated_on' => 'date',
    ];

    /**
     * @inheritDoc
     */
    public function resourceName(): string
    {
        return 'versions';
    }

    /*****************************************************************
     * Relations
     ****************************************************************/

    /**
     * The project this version belongs to
     *
     * @return BelongsTo<Project>
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, $this->project);
    }

    /**
     * Issues assigned to this version
     *
     * @return HasMany<Issue>
     */
    public function issues(): HasMany
    {
        return $this->hasMany(Issue::class, 'fixed_version_id');
    }

    /*****************************************************************
     * Utils
     ****************************************************************/

    /**
     * @inheritDoc
     */
    public function prepareBeforeCreate(array $data): array
    {
        return $this->prepareDates($data);
    }

    /**
     * @inheritDoc
     */
    public function prepareBeforeUpdate(array $data): array
    {
        return $this->prepareDates($data);
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
        return $this->formatDateFields([ 'due_date' ], $data, 'Y-m-d');
    }
}
