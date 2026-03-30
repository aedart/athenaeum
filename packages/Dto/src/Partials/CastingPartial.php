<?php

namespace Aedart\Dto\Partials;

use Aedart\Dto\Concerns\Casting;

/**
 * Casting Partial
 *
 * Deals with property value casting.
 * This partial is intended for the Dto abstraction(s)
 *
 * @deprecated use {@see \Aedart\Dto\Concerns\Casting} instead, since v10.x
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Dto\Partials
 */
trait CastingPartial
{
    use Casting;
}
