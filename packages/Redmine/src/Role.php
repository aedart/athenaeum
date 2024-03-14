<?php

namespace Aedart\Redmine;

use Aedart\Contracts\Redmine\Listable;

/**
 * Role Resource
 *
 * @see https://www.redmine.org/projects/redmine/wiki/Rest_Roles
 *
 * @property int $id
 * @property string $name
 * @property bool|null $assignable
 * @property string|null $issues_visibility
 * @property string|null $time_entries_visibility
 * @property string|null $users_visibility
 * @property string[]|null $permissions
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Redmine
 */
class Role extends RedmineApiResource implements Listable
{
    protected array $allowed = [
        'id' => 'int',
        'name' => 'string',
        'assignable' => 'bool',
        'issues_visibility' => 'string',
        'time_entries_visibility' => 'string',
        'users_visibility' => 'string',
        'permissions' => 'array',
    ];

    /**
     * @inheritDoc
     */
    public function resourceName(): string
    {
        return 'roles';
    }
}
