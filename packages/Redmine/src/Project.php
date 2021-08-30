<?php

namespace Aedart\Redmine;

use Aedart\Contracts\Redmine\Creatable;
use Aedart\Contracts\Redmine\Deletable;
use Aedart\Contracts\Redmine\Listable;
use Aedart\Contracts\Redmine\Updatable;
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
 * @property Carbon $created_on
 * @property Carbon $updated_on
 *
 * @property int|null $parent_id Property only available or expected when creating or updating resource.
 * @property bool|null $inherit_members Property only available or expected when creating or updating resource.
 * @property int|null $default_assigned_to_id Property only available or expected when creating or updating resource.
 * @property int|null $default_version_id Property only available or expected when creating or updating resource.
 * @property int[]|null $tracker_ids Property only available or expected when creating or updating resource.
 * @property string[]|null $enabled_module_names Property only available or expected when creating or updating resource.
 * @property int[]|null $issue_custom_field_ids Property only available or expected when creating or updating resource.
 *
 * @property ListOfReferences<Reference>|Reference[]|null $trackers Related data that can be requested included.
 * @property ListOfReferences<Reference>|Reference[]|null $issue_categories Related data that can be requested included.
 * @property ListOfReferences<Reference>|Reference[]|null $enabled_modules Related data that can be requested included.
 * @property ListOfReferences<Reference>|Reference[]|null $time_entry_activities Related data that can be requested included.
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Redmine
 */
class Project extends RedmineResource implements
    Listable,
    Creatable,
    Updatable,
    Deletable
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
