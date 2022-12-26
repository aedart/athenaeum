<?php

namespace Aedart\ETags\Preconditions\Rfc9110\Concerns;

use Aedart\Contracts\ETags\Preconditions\RangeValidator;
use Aedart\Contracts\ETags\Preconditions\ResourceContext;
use Aedart\Support\Facades\IoCFacade;
use Ramsey\Collection\CollectionInterface;
use Ramsey\Http\Range\Unit\UnitRangeInterface;
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
     * Verified range sets
     *
     * @var CollectionInterface<UnitRangeInterface>|null
     */
    protected CollectionInterface|null $verifiedRanges = null;

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
        $this->verifiedRanges = $collection;
        return true;
    }

    /**
     * Returns the verified range sets
     *
     * @return CollectionInterface<UnitRangeInterface>|null
     */
    protected function getVerifiedRanges(): CollectionInterface|null
    {
        return $this->verifiedRanges;
    }

    /**
     * Creates a new range validator instance
     *
     * @param  ResourceContext  $resource
     *
     * @return RangeValidator
     */
    protected function makeRangeValidator(ResourceContext $resource): RangeValidator
    {
        return IoCFacade::make(RangeValidator::class, [
            'rangeUnit' => $resource->allowedRangeUnit(),
            'maxRangeSets' => $resource->maximumRangeSets()
        ])
            ->setRequest($this->getRequest())
            ->setActions($this->getActions());
    }
}