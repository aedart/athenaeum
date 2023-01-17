<?php

namespace Aedart\Redmine\Partials;

use Aedart\Dto\ArrayDto;

/**
 * Membership Reference
 *
 * @property int $id
 * @property Reference $project
 * @property ListOfRoleReferences<RoleReference>|RoleReference[]|null $roles
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Redmine\Partials
 */
class MembershipReference extends ArrayDto
{
    protected array $allowed = [
        'id' => 'int',
        'project' => Reference::class,
        'roles' => ListOfRoleReferences::class
    ];
}
