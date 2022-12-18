<?php

namespace Aedart\ETags\Preconditions\Additional;

use Aedart\Contracts\ETags\Preconditions\ResourceContext;
use Aedart\ETags\Preconditions\BasePrecondition;

/**
 * Range extension
 *
 * @see https://httpwg.org/specs/rfc9110.html#field.range
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\ETags\Preconditions\Extensions
 */
class Range extends BasePrecondition
{
    /**
     * @inheritDoc
     */
    public function isApplicable(ResourceContext $resource): bool
    {
        // TODO: Implement isApplicable() method.
    }

    /**
     * @inheritDoc
     */
    public function passes(ResourceContext $resource): bool
    {
        // TODO: Implement passes() method.
    }

    /**
     * @inheritDoc
     */
    public function whenPasses(ResourceContext $resource): ResourceContext|string
    {
        // TODO: Implement whenPasses() method.
    }

    /**
     * @inheritDoc
     */
    public function whenFails(ResourceContext $resource): ResourceContext|string
    {
        // TODO: Implement whenFails() method.
    }
}