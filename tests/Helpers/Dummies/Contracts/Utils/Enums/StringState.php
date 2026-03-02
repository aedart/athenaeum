<?php

namespace Aedart\Tests\Helpers\Dummies\Contracts\Utils\Enums;

use Aedart\Contracts\Utils\Enums\Concerns;

/**
 * String State
 *
 * FOR TESTING PURPOSES ONLY
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Contracts\Utils\Enums
 */
enum StringState: string
{
    use Concerns\BackedEnums;

    case OPEN = 'open';
    case CLOSED = 'closed';
}
