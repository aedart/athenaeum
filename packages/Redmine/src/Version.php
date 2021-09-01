<?php

namespace Aedart\Redmine;

use Aedart\Contracts\Redmine\Connection;
use Aedart\Contracts\Redmine\Deletable;
use Aedart\Contracts\Redmine\PaginatedResults as PaginatedResultsInterface;
use Aedart\Contracts\Redmine\Resource;
use Aedart\Contracts\Redmine\Updatable;
use Aedart\Redmine\Exceptions\RedmineException;
use Aedart\Redmine\Pagination\PaginatedResults;
use Aedart\Redmine\Partials\Reference;
use Aedart\Redmine\Relations\BelongsTo;
use Carbon\Carbon;
use JsonException;
use Throwable;

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
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Redmine
 */
class Version extends RedmineResource implements
    Updatable,
    Deletable
{
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

    /**
     * Fetch versions for the given project
     *
     * @param int|string|Project $project Project identifier or project instance
     * @param callable|null $filters [optional] Callback that applies filters on the given Request {@see Builder}.
     *                               The callback MUST return a valid {@see Builder}
     * @param int $limit [optional]
     * @param int $offset [optional]
     * @param string|Connection|null $connection [optional] Redmine connection profile
     *
     * @return PaginatedResultsInterface<static>
     *
     * @throws Throwable
     * @throws RedmineException
     * @throws JsonException
     */
    public static function fetchForProject(
        $project,
        ?callable $filters = null,
        int $limit = 10,
        int $offset = 0,
        $connection = null
    ): PaginatedResultsInterface {
        $endpoint = static::projectVersionEndpoint($project);

        $resource = static::make([], $connection);
        $response = $resource
            ->applyFiltersCallback($filters)
            ->limit($limit)
            ->offset($offset)
            ->get($endpoint);

        return PaginatedResults::fromResponse($response, $resource);
    }

    /**
     * Create a new version for given project
     *
     * @param int|string|Project $project Project identifier or project instance
     * @param array $data
     * @param string|Connection|null $connection [optional] Redmine connection profile
     *
     * @return static
     *
     * @throws JsonException
     * @throws Throwable
     */
    public static function createForProject($project, array $data, $connection = null)
    {
        $endpoint = static::projectVersionEndpoint($project);
        $resource = static::make([], $connection);

        // Prepare payload
        $prepared = $resource->prepareBeforeCreate($data);
        $payload = [
            $resource->resourceNameSingular() => $prepared
        ];

        // Perform create request
        $response = $resource
            ->request()
            ->post($endpoint, $payload);

        // Extract and (re)populate resource
        return $resource->fill(
            $resource->decodeSingle($response)
        );
    }

    /**
     * Returns a version url for given project
     *
     * @param int|string|Project $project Project identifier or project instance
     *
     * @return string
     *
     * @throws RedmineException|Throwable
     */
    public static function projectVersionEndpoint($project): string
    {
        $id = $project;
        if ($project instanceof Resource) {
            $id = $project->id();
        }

        if (!isset($id)) {
            throw new RedmineException('Unable to resolve project version endpoint resource url');
        }

        return Project::make()->endpoint($id, 'versions');
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
