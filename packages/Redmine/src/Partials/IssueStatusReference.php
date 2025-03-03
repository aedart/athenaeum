<?php

namespace Aedart\Redmine\Partials;

/**
 * Issue Status Reference
 *
 * @property string|int|null $id
 * @property string $name
 * @property bool $is_closed
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Redmine\Partials
 */
class IssueStatusReference extends Reference
{
    protected array $allowed = [
        'id' => 'string', // type ignore - see getter / setter
        'name' => 'string',
        'is_closed' => 'bool'
    ];
}
