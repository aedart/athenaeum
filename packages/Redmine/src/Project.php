<?php

namespace Aedart\Redmine;

use Aedart\Redmine\Partials\ListOfReferences;
use Aedart\Redmine\Partials\Reference;
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
 * @property Reference|null $parent
 * @property Reference|null $default_version
 * @property Reference|null $default_assignee
 * @property Carbon $created_om
 * @property Carbon $updated_on
 *
 * @property ListOfReferences<Reference>|null $trackers
 * @property ListOfReferences<Reference>|null $issue_categories
 * @property ListOfReferences<Reference>|null $enabled_modules
 * @property ListOfReferences<Reference>|null $time_entry_activities
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
        'parent' => Reference::class,
        'default_version' => Reference::class,
        'default_assignee' => Reference::class,
        'created_on' => 'date',
        'updated_on' => 'date',

        // Only when creating or updating
        'parent_id' => 'int',
        'inherit_members' => 'bool',
        'default_assigned_to_id' => 'int',
        'default_version_id' => 'int',
        'tracker_ids' => 'array',
        'enabled_module_names' => 'array',
        'issue_custom_field_ids' => 'array',

        // Related (can be included)
        'trackers' => ListOfReferences::class,
        'issue_categories' => ListOfReferences::class,
        'enabled_modules' => ListOfReferences::class,
        'time_entry_activities' => ListOfReferences::class,
    ];

    /**
     * @inheritDoc
     */
    public function resourceName(): string
    {
        return 'projects';
    }
}