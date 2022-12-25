<?php

namespace Aedart\ETags\Preconditions\Rfc9110\Concerns;

use Aedart\Contracts\ETags\Preconditions\RangeValidator;
use Aedart\Contracts\ETags\Preconditions\ResourceContext;
use Ramsey\Collection\CollectionInterface;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

/**
 * Concerns Range Validation
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\ETags\Preconditions\Rfc9110\Concerns
 */
trait RangeValidation
{
    /**
     * Validated range sets
     *
     * @var CollectionInterface|null
     */
    protected CollectionInterface|null $ranges = null;

    /**
     * Determine if requested "Range" is applicable
     *
     * Method can choose to abort the request, if requested "Range" is malformed or otherwise
     * invalid.
     *
     * @param  ResourceContext  $resource
     *
     * @return bool
     *
     * @throws HttpExceptionInterface
     */
    protected function isRangeApplicable(ResourceContext $resource): bool
    {
        $collection = $this
            ->makeRangeValidator($resource)
            ->validate($resource);

        // Edge case: no "Range" header available in request. Or [...] An origin server MUST
        // ignore a Range header field that contains a range unit it does not understand [...]
        // Regardless, we just mark range as not applicable.
        if ($collection->isEmpty()) {
            return false;
        }

        // Store a reference to the validated range sets and evaluate as true (Range is applicable).
        $this->ranges = $collection;
        return true;
    }

    // TODO: ...
    protected function makeRangeValidator(ResourceContext $resource): RangeValidator
    {
        // TODO: Use IoC to create validator instance. Configure it based on info. from
        // TODO: resource context.

        // TODO: Set current request
        // TODO: Set actions
    }

}