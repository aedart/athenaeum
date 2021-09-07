<?php

namespace Aedart\Redmine;

use Aedart\Contracts\Redmine\Deletable;
use Aedart\Contracts\Redmine\Updatable;
use Aedart\Redmine\Partials\ListOfRoleReferences;
use Aedart\Redmine\Partials\Reference;
use Aedart\Redmine\Partials\RoleReference;
use Aedart\Redmine\Relations\BelongsTo;

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
class ProjectMembership extends RedmineApiResource implements
    Updatable,
    Deletable
{
    use Concerns\ProjectDependentResource;

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
