<?php

namespace Aedart\Dto\Partials;

use Aedart\Dto\Concerns;

/**
 * IoC Partial
 *
 * Keeps track of the assigned (or default) Service Container
 * and offers utils for resolving dependencies for mutator
 * methods.
 *
 * This partial is intended for the Dto abstraction(s)
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Dto\Partials
 */
trait IoCPartial
{
    use Concerns\Dependencies;
}
