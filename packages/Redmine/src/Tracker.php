<?php

namespace Aedart\Redmine;

use Aedart\Contracts\Redmine\Listable;
use Aedart\Redmine\Partials\Reference;
use Aedart\Redmine\Relations\HasMany;
use Aedart\Redmine\Relations\OneFromList;

/**
 * Tracker Resource
 *
 * @see https://www.redmine.org/projects/redmine/wiki/Rest_Trackers
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property Reference $default_status
 * @property string[]|null $enabled_standard_fields
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Redmine
 */
class Tracker extends RedmineApiResource implements
    Listable
{
    protected array $allowed = [
        'id' => 'int',
        'name' => 'string',
        'description' => 'string',
        'default_status' => Reference::class,
        'enabled_standard_fields' => 'array'
    ];

    /**
     * @inheritDoc
     */
    public function resourceName(): string
    {
        return 'trackers';
    }

    /*****************************************************************
     * Relations
     ****************************************************************/

    /**
     * Teh default issue status of this tracker
     *
     * @return OneFromList<IssueStatus>
     */
    public function defaultStatus(): OneFromList
    {
        return $this->oneFrom(IssueStatus::class, $this->default_status);
    }

    /**
     * Issues of this tracker type
     *
     * @return HasMany<Issue>
     */
    public function issues(): HasMany
    {
        return $this->hasMany(Issue::class, 'tracker_id');
    }
}
