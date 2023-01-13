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
     * Last verified range sets
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
        // Validate the requested "Range" header. If invalid, the validator will
        // abort the request using appropriate abort actions.
        $collection = $this
            ->makeRangeValidator($resource)
            ->validate($resource);

        // In situations when this method is invoked, but request does not contain
        // a "Range" header, then empty range sets collection is returned. If so,
        // the range is not applicable.
        if ($collection->isEmpty()) {
            return false;
        }

        // Otherwise, the range is applicable and we store a reference to the verified range sets.
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