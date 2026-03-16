<?php

namespace Aedart\Tests\Helpers\Dummies\Dto;

use Aedart\Contracts\Utils\Enums\Concerns;

/**
 * Availability
 *
 * FOR TESTING ONLY...
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Dto
 */
enum Availability: int
{
    use Concerns\BackedEnums;

    case AVAILABLE = 10;
    case UNAVAILABLE = 20;
}
