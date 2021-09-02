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
use Throwable;

/**
 * Issue Category Resource
 *
 * @see https://www.redmine.org/projects/redmine/wiki/Rest_IssueCategories
 *
 * @property int $id
 * @property string $name
 * @property Reference $project
 * @property Reference|null $assigned_to
 *
 * @property int $assigned_to_id Property only available or expected when creating or updating resource.
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Redmine
 */
class IssueCategory extends RedmineResource implements
    Updatable,
    Deletable
{
    protected array $allowed = [
        'id' => 'int',
        'name' => 'string',
        'project' => Reference::class,
        'assigned_to' => Reference::class,

        // Only when creating or updating
        'assigned_to_id' => 'int'
    ];

    /**
     * @inheritDoc
     */
    public function resourceName(): string
    {
        return 'issue_categories';
    }

    /**
     * Fetch issue categories for given project
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
     * @throws \Aedart\Contracts\Redmine\Exceptions\RedmineException
     * @throws \JsonException
     */
    public static function fetchForProject(
        $project,
        ?callable $filters = null,
        int $limit = 10,
        int $offset = 0,
        $connection = null
    ): PaginatedResultsInterface {
        $endpoint = static::projectIssueCategoryEndpoint($project);

        $resource = static::make([], $connection);
        $response = $resource
            ->applyFiltersCallback($filters)
            ->limit($limit)
            ->offset($offset)
            ->get($endpoint);

        return PaginatedResults::fromResponse($response, $resource);
    }

    /**
     * Create a new issue category for given project
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
        $endpoint = static::projectIssueCategoryEndpoint($project);
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
     * Returns an issue category url for given project
     *
     * @param int|string|Project $project Project identifier or project instance
     *
     * @return string
     *
     * @throws RedmineException|Throwable
     */
    public static function projectIssueCategoryEndpoint($project): string
    {
        $id = $project;
        if ($project instanceof Resource) {
            $id = $project->id();
        }

        if (!isset($id)) {
            throw new RedmineException('Unable to resolve project issue category endpoint resource url');
        }

        return Project::make()->endpoint($id, 'issue_categories');
    }

    /*****************************************************************
     * Relations
     ****************************************************************/

    /**
     * The project this issue category belongs to
     *
     * @return BelongsTo<Project>
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, $this->project);
    }
}
