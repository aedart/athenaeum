<?php

namespace Aedart\Redmine;

use Aedart\Contracts\Redmine\Connection;
use Aedart\Contracts\Redmine\Deletable;
use Aedart\Contracts\Redmine\PaginatedResults as PaginatedResultsInterface;
use Aedart\Contracts\Redmine\Resource;
use Aedart\Contracts\Redmine\Updatable;
use Aedart\Redmine\Exceptions\RedmineException;
use Aedart\Redmine\Pagination\PaginatedResults;
use Aedart\Redmine\Partials\ListOfRoleReferences;
use Aedart\Redmine\Partials\Reference;
use Aedart\Redmine\Partials\RoleReference;
use Aedart\Redmine\Relations\BelongsTo;
use Throwable;

/**
 * Project Membership Resource
 *
 * @see https://www.redmine.org/projects/redmine/wiki/Rest_Memberships
 *
 * @property int $id
 * @property Reference $project
 * @property Reference|null $user
 * @property Reference|null $group
 * @property ListOfRoleReferences<RoleReference>|RoleReference[] $roles
 *
 * @property int|null $user_id NOTE: user or group id. Property only available or expected when creating or updating resource.
 * @property int[]|null $role_ids Property only available or expected when creating or updating resource.
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Redmine
 */
class ProjectMembership extends RedmineResource implements
    Updatable,
    Deletable
{
    protected array $allowed = [
        'id' => 'int',
        'project' => Reference::class,
        'user' => Reference::class,
        'group' => Reference::class,
        'roles' => ListOfRoleReferences::class,

        // Only when creating or updating
        'user_id' => 'int', // NOTE: Can also be a group id!
        'role_ids' => 'array'
    ];

    /**
     * @inheritDoc
     */
    public function resourceName(): string
    {
        return 'memberships';
    }

    /**
     * Fetch memberships for the given project
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
        $endpoint = static::projectMembershipEndpoint($project);

        $resource = static::make([], $connection);
        $response = $resource
            ->applyFiltersCallback($filters)
            ->limit($limit)
            ->offset($offset)
            ->get($endpoint);

        return PaginatedResults::fromResponse($response, $resource);
    }

    /**
     * Create a new membership for given project
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
        $endpoint = static::projectMembershipEndpoint($project);
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
    public static function projectMembershipEndpoint($project): string
    {
        $id = $project;
        if ($project instanceof Resource) {
            $id = $project->id();
        }

        if (!isset($id)) {
            throw new RedmineException('Unable to resolve project membership endpoint resource url');
        }

        return Project::make()->endpoint($id, 'memberships');
    }

    /**
     * Determine if this membership is valid for a single
     * user
     *
     * @see isGroupMembership
     *
     * @return bool
     */
    public function isUserMembership(): bool
    {
        return isset($this->user);
    }

    /**
     * Determine if this membership is valid for a group
     * of users
     *
     * @see isUserMembership
     *
     * @return bool
     */
    public function isGroupMembership(): bool
    {
        return isset($this->group);
    }

    /*****************************************************************
     * Relations
     ****************************************************************/

    /**
     * The project this membership is valid for
     *
     * @return BelongsTo<Project>
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, $this->project);
    }

    /**
     * The user that owns membership
     *
     * @return BelongsTo<User>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, $this->user);
    }

    /**
     * The group of users that are part of this membership
     *
     * @return BelongsTo<Group>
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class, $this->group);
    }
}
