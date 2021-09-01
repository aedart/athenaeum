<?php

namespace Aedart\Redmine;

/**
 * Issue Priority Resource (Enumeration)
 *
 * @see https://www.redmine.org/projects/redmine/wiki/Rest_Enumerations
 *
 * @property int $id
 * @property string $name
 * @property bool $is_default
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Redmine
 */
class IssuePriority extends Enumeration
{
    protected array $allowed = [
        'id' => 'int',
        'name' => 'string',
        'is_default' => 'bool'
    ];

    /**
     * @inheritDoc
     */
    public function resourceName(): string
    {
        return 'issue_priorities';
    }
}
