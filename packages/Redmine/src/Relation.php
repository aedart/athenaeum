<?php

namespace Aedart\Redmine;

use Aedart\Contracts\Redmine\Deletable;

/**
 * Issue Relation Resource
 *
 * @see https://www.redmine.org/projects/redmine/wiki/Rest_IssueRelations
 *
 * @property int $id
 * @property int $issue_id
 * @property int $issue_to_id
 * @property string $relation_type
 * @property float $delay
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Redmine
 */
class Relation extends RedmineResource implements
    Deletable
{
    protected array $allowed = [
        'id' => 'int',
        'issue_id' => 'int',
        'issue_to_id' => 'int',
        'relation_type' => 'string',
        'delay' => 'float',
    ];

    /**
     * @inheritDoc
     */
    public function resourceName(): string
    {
        return 'relations';
    }

    // TODO: Create new relation - for a specific issue
}