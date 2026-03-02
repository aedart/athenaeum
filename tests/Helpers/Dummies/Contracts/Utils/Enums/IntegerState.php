<?php

namespace Aedart\Tests\Helpers\Dummies\Contracts\Utils\Enums;

use Aedart\Contracts\Utils\Enums\Concerns;

/**
 * Integer State
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Contracts\Utils\Enums
 */
enum IntegerState: int
{
    use Concerns\BackedEnums;

    case OPEN = 10;
    case CLOSED = 20;
}
