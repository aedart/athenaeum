<?php

namespace Aedart\Redmine;

use Aedart\Redmine\Relations\HasMany;

/**
 * Issue Priority Resource (Enumeration)
 *
 * @see https://www.redmine.org/projects/redmine/wiki/Rest_Enumerations
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Redmine
 */
class IssuePriority extends Enumeration
{
    /**
     * @inheritDoc
     */
    public function resourceName(): string
    {
        return 'issue_priorities';
    }

    /*****************************************************************
     * Relations
     ****************************************************************/

    /**
     * Issues with this priority
     *
     * @return HasMany<Issue>
     */
    public function issues(): HasMany
    {
        return $this->hasMany(Issue::class, 'priority_id');
    }
}
