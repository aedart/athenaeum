<?php

namespace Aedart\ETags\Preconditions;

use Aedart\Contracts\ETags\Preconditions\Precondition;
use Aedart\Contracts\ETags\Preconditions\ResourceContext;
use DateTimeInterface;
use Illuminate\Support\Carbon;
use LogicException;
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
    public function process(ResourceContext $resource): ResourceContext|string|null
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
     * @return ResourceContext|string|null Class path to another precondition to be evaluated,
     *                                     null if evaluator should continue to next precondition, or
     *                                     {@see ResourceContext} when request should proceed
     *                                     (stop evaluation of other preconditions).
     *
     * @throws HttpExceptionInterface
     */
    abstract public function whenPasses(ResourceContext $resource): ResourceContext|string|null;

    /**
     * Process unsuccessful precondition evaluation
     *
     * @param  ResourceContext  $resource
     *
     * @return ResourceContext|string|null Class path to another precondition to be evaluated,
     *                                     null if evaluator should continue to next precondition, or
     *                                     {@see ResourceContext} when request should proceed
     *                                     (stop evaluation of other preconditions).
     *
     * @throws HttpExceptionInterface
     */
    abstract public function whenFails(ResourceContext $resource): ResourceContext|string|null;

    /**
     * Resolve "last modified date" for given resource
     *
     * @param ResourceContext $resource
     *
     * @return Carbon
     */
    protected function resolveLastModifiedDate(ResourceContext $resource): Carbon
    {
        // Method SHOULD NOT be invoked when resource does not have a last modified date!
        if (!$resource->hasLastModifiedDate()) {
            throw new LogicException('Resource Context does not have a last modified date set!');
        }

        // When comparing a resource's "last modified date", the given datetime instance
        // might contain a high precision, e.g. milliseconds, whereas a precondition's
        // datetime instance will not (converted from string value). To ensure this
        // does not become a problem, the last modified date to formatted and re-converted
        // to a datetime instance.

        return $this->reducePrecisionToSeconds($resource->lastModifiedDate());
    }

    /**
     * Reconverts given datetime
     *
     * Method formats given datetime to RFC 7231 and then back to a datetime
     * instance. Doing so will reduce date's precision to seconds!
     *
     * @param DateTimeInterface $datetime
     *
     * @return Carbon
     */
    protected function reducePrecisionToSeconds(DateTimeInterface $datetime): Carbon
    {
        $original = Carbon::instance($datetime);

        return Carbon::make($original->toRfc7231String());
    }
}
