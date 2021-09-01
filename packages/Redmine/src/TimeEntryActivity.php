<?php

namespace Aedart\Redmine;

/**
 * Time Entry Activity (Enumeration)
 *
 * @see https://www.redmine.org/projects/redmine/wiki/Rest_Enumerations
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Redmine
 */
class TimeEntryActivity extends Enumeration
{
    /**
     * @inheritDoc
     */
    public function resourceName(): string
    {
        return 'time_entry_activities';
    }
}
