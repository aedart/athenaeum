<?php

namespace Aedart\Redmine;

use Aedart\Contracts\Redmine\Creatable;
use Aedart\Contracts\Redmine\Deletable;
use Aedart\Contracts\Redmine\Listable;
use Aedart\Contracts\Redmine\Updatable;
use Aedart\Redmine\Partials\ListOfReferences;
use Aedart\Redmine\Partials\Reference;
use Aedart\Redmine\Relations\HasMany;
use JsonException;

/**
 * Group Resource
 *
 * @see https://www.redmine.org/projects/redmine/wiki/Rest_Groups
 *
 * @property int $id
 * @property string $name
 *
 * @property int[] $user_ids Property only available or expected when creating or updating resource.
 *
 * @property ListOfReferences<Reference>|Reference[]|null $users Related data that can be requested included.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Redmine
 */
class Group extends RedmineApiResource implements
    Listable,
    Creatable,
    Updatable,
    Deletable
{
    protected array $allowed = [
        'id' => 'int',
        'name' => 'string',

        // Only when creating or updating
        'user_ids' => 'array',

        // Related (can be included)
        'users' => ListOfReferences::class
    ];

    /**
     * @inheritDoc
     */
    public function resourceName(): string
    {
        return 'groups';
    }

    /*****************************************************************
     * Users
     ****************************************************************/

    /**
     * Assign given user to this group
     *
     * @param int|User|Reference $user
     * @param bool $reload [optional] Resource is force reloaded from
     *                     Redmine's API.
     *
     * @return bool
     *
     * @throws JsonException
     */
    public function addUser(int|User|Reference $user, bool $reload = false): bool
    {
        $id = $this->resolveUserId($user);

        $endpoint = $this->endpoint($this->id(), 'users');
        $payload = [
            'user_id' => $id
        ];

        $this
            ->request()
            ->post($endpoint, $payload);

        if ($reload) {
            return $this
                ->withIncludes([ 'users' ])
                ->reload();
        }

        return true;
    }

    /**
     * Unassign given user from this group
     *
     * @param int|User|Reference $user
     * @param bool $reload [optional] Resource is force reloaded from
     *                     Redmine's API.
     *
     * @return bool
     *
     * @throws JsonException
     */
    public function removeUser(int|User|Reference $user, bool $reload = false): bool
    {
        $id = $this->resolveUserId($user);

        $endpoint = $this->endpoint($this->id(), 'users', $id);

        $this
            ->request()
            ->delete($endpoint);

        if ($reload) {
            return $this
                ->withIncludes([ 'users' ])
                ->reload();
        }

        return true;
    }

    /*****************************************************************
     * Relations
     ****************************************************************/

    /**
     * Issues that are assigned directly to this group
     *
     * @return HasMany<Issue>
     */
    public function assignedIssues(): HasMany
    {
        return $this->hasMany(Issue::class, 'assigned_to_id');
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Resolves the user id
     *
     * @param int|User|Reference $user
     *
     * @return int
     */
    protected function resolveUserId(int|User|Reference $user): int
    {
        if ($user instanceof User || $user instanceof Reference) {
            return $user->id;
        }

        return $user;
    }
}
