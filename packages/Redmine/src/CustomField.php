<?php

namespace Aedart\Redmine;

use Aedart\Contracts\Redmine\Listable;
use Aedart\Redmine\Partials\ListOfPossibleValues;
use Aedart\Redmine\Partials\ListOfReferences;
use Aedart\Redmine\Partials\PossibleValue;
use Aedart\Redmine\Partials\Reference;
use Aedart\Redmine\Relations\HasMany;

/**
 * Custom Field Resource
 *
 * **Caution**: _This type of resource only supports listing - and nothing else!_
 *
 * @see https://www.redmine.org/projects/redmine/wiki/Rest_CustomFields
 *
 * @property int $id
 * @property string $name
 * @property string $customized_type
 * @property string $field_format
 * @property string $regexp
 * @property int $min_length
 * @property int $max_length
 * @property bool $is_required
 * @property bool $is_filter
 * @property bool $searchable
 * @property bool $multiple
 * @property string $default_value
 * @property bool $visible
 * @property ListOfPossibleValues<PossibleValue>|PossibleValue[]|null $possible_values
 * @property ListOfReferences<Reference>|Reference[]|null $trackers
 * @property ListOfReferences<Reference>|Reference[]|null $roles
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Redmine
 */
class CustomField extends RedmineApiResource implements
    Listable
{
    protected array $allowed = [
        'id' => 'int',
        'name' => 'string',
        'customized_type' => 'string',
        'field_format' => 'string',
        'regexp' => 'string',
        'min_length' => 'int',
        'max_length' => 'int',
        'is_required' => 'bool',
        'is_filter' => 'bool',
        'searchable' => 'bool',
        'multiple' => 'bool',
        'default_value' => 'string',
        'visible' => 'bool',
        'possible_values' => ListOfPossibleValues::class,
        'trackers' => ListOfReferences::class,
        'roles' => ListOfReferences::class,
    ];

    /**
     * @inheritDoc
     */
    public function resourceName(): string
    {
        return 'custom_fields';
    }

    /*****************************************************************
     * Relations
     ****************************************************************/

    /**
     * Issues using this custom field, matching the given value
     *
     * @see https://www.redmine.org/projects/redmine/wiki/Rest_Issues
     *
     * @param string|int $value
     *
     * @return HasMany<Issue>
     */
    public function issuesMatching(string|int $value): HasMany
    {
        $filterKey = 'cf_' . $this->id();

        return $this->hasMany(Issue::class, $filterKey)
            ->ownKey($value);
    }
}
