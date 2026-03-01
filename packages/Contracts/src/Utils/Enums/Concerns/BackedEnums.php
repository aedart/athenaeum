<?php

namespace Aedart\Contracts\Utils\Enums\Concerns;

/**
 * Concerns Backed Enums
 *
 * @see \BackedEnum
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Utils\Enums\Concerns
 */
trait BackedEnums
{
    use Matching;
    use Jsonable;
}
