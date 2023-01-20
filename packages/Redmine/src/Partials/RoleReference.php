<?php

namespace Aedart\Redmine\Partials;

use Aedart\Dto\ArrayDto;

/**
 * Role Reference
 *
 * @property int $id
 * @property string $name
 * @property bool|null $inherited
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Redmine\Partials
 */
class RoleReference extends ArrayDto
{
    protected array $allowed = [
        'id' => 'int',
        'name' => 'string',
        'inherited' => 'bool'
    ];
}
