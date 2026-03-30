<?php

namespace Aedart\Tests\Helpers\Dummies\Contracts\Utils\Enums;

use Aedart\Contracts\Utils\Enums\Concerns;

/**
 * Basic State
 *
 * FOR TESTING PURPOSES ONLY
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Contracts\Utils\Enums
 */
enum BasicState
{
    use Concerns\Enums;

    case OPEN;
    case CLOSED;
}
