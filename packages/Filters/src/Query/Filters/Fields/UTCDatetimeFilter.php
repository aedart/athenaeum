<?php

namespace Aedart\Filters\Query\Filters\Fields;

/**
 * UTC Datetime Filter
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Filters\Query\Filters\Fields
 */
class UTCDatetimeFilter extends DatetimeFilter
{
    /**
     * State whether given datetime must be converted
     * to UTC or not
     *
     * @var bool
     */
    protected bool $utc = true;
}
