<?php

namespace Aedart\ETags\Preconditions;

use Aedart\Contracts\ETags\Preconditions\Precondition;
use Aedart\Contracts\ETags\Preconditions\ResourceContext;
use Aedart\ETags\Preconditions\Concerns;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

/**
 * Base Request Precondition
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\ETags\Preconditions
 */
abstract class BasePrecondition implements Precondition
{
    use Concerns\CurrentRequest;
    use Concerns\Actions;

    /**
     * @inheritDoc
     */
    public function process(ResourceContext $resource): ResourceContext|string
    {
        if ($this->passes($resource)) {
            return $this->whenPasses($resource);
        }

        return $this->whenFails($resource);
    }

    /**
     * Process successful precondition evaluation
     *
     * @param  ResourceContext  $resource
     *
     * @return ResourceContext|string Class path to another precondition to be evaluated, or
     *                                {@see ResourceContext} when request should proceed.
     *
     * @throws HttpExceptionInterface
     */
    abstract public function whenPasses(ResourceContext $resource): ResourceContext|string;

    /**
     * Process unsuccessful precondition evaluation
     *
     * @param  ResourceContext  $resource
     *
     * @return ResourceContext|string Class path to another precondition to be evaluated, or
     *                                {@see ResourceContext} when request should proceed.
     *
     * @throws HttpExceptionInterface
     */
    abstract public function whenFails(ResourceContext $resource): ResourceContext|string;
}