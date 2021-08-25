<?php

namespace Aedart\Redmine;

use Carbon\Carbon;

/**
 * Project Resource
 *
 * @see https://www.redmine.org/projects/redmine/wiki/Rest_Projects
 *
 * @property int $id
 * @property string $name
 * @property string $identifier
 * @property string $description
 * @property string $homepage
 * @property int $status
 * @property bool $is_public
 * @property bool $inherit_members TODO: ??? where does this come from!
 * @property Carbon $created_om
 * @property Carbon $updated_on
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Redmine
 */
class Project extends RedmineResource
{
    protected array $allowed = [
        'id' => 'int',
        'name' => 'string',
        'identifier' => 'string',
        'description' => 'string',
        'homepage' => 'string',
        'status' => 'int',
        'is_public' => 'bool',
        'inherit_members' => 'bool', // TODO: Where does this come from????
        // TODO: default_version
        // TODO: default_assignee
        // TODO: parent
        'created_on' => 'date',
        'updated_on' => 'date'
    ];

    /**
     * @inheritDoc
     */
    public function resourceName(): string
    {
        return 'projects';
    }
}