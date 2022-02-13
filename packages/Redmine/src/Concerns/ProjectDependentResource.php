<?php

namespace Aedart\Redmine\Concerns;

use Aedart\Contracts\Redmine\ApiResource;
use Aedart\Contracts\Redmine\Connection;
use Aedart\Contracts\Redmine\PaginatedResults as PaginatedResultsInterface;
use Aedart\Redmine\Exceptions\RedmineException;
use Aedart\Redmine\Pagination\PaginatedResults;
use Aedart\Redmine\Project;
use JsonException;
use Throwable;

/**
 * Concerns Project Dependent Resource
 *
 * To be used for resource that are strictly tight to a project, e.g.
 * resources that can only be listed or created for a project.
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Redmine\Concerns
 */
trait ProjectDependentResource
{
    /**
     * Fetch for the given project
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
        int|string|Project $project,
        callable|null $filters = null,
        int $limit = 10,
        int $offset = 0,
        string|Connection|null $connection = null
    ): PaginatedResultsInterface {
        $endpoint = static::projectRelatedEndpoint($project);

        $resource = static::make([], $connection);
        $response = $resource
            ->applyFiltersCallback($filters)
            ->limit($limit)
            ->offset($offset)
            ->get($endpoint);

        return PaginatedResults::fromResponse($response, $resource);
    }

    /**
     * Create a new resource for given project
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
    public static function createForProject(int|string|Project $project, array $data, string|Connection|null $connection = null): static
    {
        $endpoint = static::projectRelatedEndpoint($project);
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
     * Returns listing url for this resource, in relation to given project
     *
     * @param int|string|Project $project Project identifier or project instance
     *
     * @return string
     *
     * @throws RedmineException
     * @throws Throwable
     */
    public static function projectRelatedEndpoint(int|string|Project $project): string
    {
        $id = $project;
        if ($project instanceof ApiResource) {
            $id = $project->id();
        }

        $resource = static::make();

        if (!isset($id)) {
            throw new RedmineException(sprintf(
                'Unable to resolve %s version endpoint resource url',
                $resource->resourceNameSingular()
            ));
        }

        return Project::make()->endpoint($id, $resource->resourceName());
    }
}
