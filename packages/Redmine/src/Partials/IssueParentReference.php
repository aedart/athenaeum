<?php

namespace Aedart\Redmine\Partials;

use Aedart\Dto\ArrayDto;

/**
 * Issue Parent Reference
 *
 * @property int|null $id
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Redmine\Partials
 */
class IssueParentReference extends ArrayDto
{
    protected array $allowed = [
        'id' => 'int',
    ];
}
