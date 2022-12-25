<?php

namespace Aedart\ETags\Preconditions\Actions;

use Aedart\Contracts\ETags\Preconditions\Actions;
use Aedart\Contracts\ETags\Preconditions\ResourceContext;
use Aedart\ETags\Preconditions\Validators\Exceptions\RangeNotSatisfiable;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\PreconditionFailedHttpException;

/**
 * Default Actions
 *
 * @see Actions
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\ETags\Preconditions\Actions
 */
class DefaultActions implements Actions
{
    /**
     * @inheritDoc
     */
    public function abortStateChangeAlreadySucceeded(ResourceContext $resource)
    {
        throw new HttpException(200);
    }

    /**
     * @inheritDoc
     */
    public function abortPreconditionFailed(ResourceContext $resource)
    {
        throw new PreconditionFailedHttpException();
    }

    /**
     * @inheritDoc
     */
    public function abortNotModified(ResourceContext $resource)
    {
        throw new HttpException(304);
    }

    /**
     * @inheritDoc
     */
    public function abortBadRequest(ResourceContext $resource, ?string $reason = null)
    {
        $reason = $reason ?? '';

        throw new BadRequestHttpException($reason);
    }

    /**
     * @inheritDoc
     */
    public function abortRangeNotSatisfiable(
        ResourceContext $resource,
        string $range,
        int $totalSize,
        string $rangeUnit,
        ?string $reason = null
    ) {
        $reason = $reason ?? '';

        throw new RangeNotSatisfiable($range, $totalSize, $rangeUnit, $reason);
    }

    /**
     * @inheritDoc
     */
    public function processRangeHeader(ResourceContext $resource): mixed
    {
        // Application SHOULD process the "Range" header field.
        return $resource->set('process_range', true);
    }

    /**
     * @inheritDoc
     */
    public function ignoreRangeHeader(ResourceContext $resource): mixed
    {
        // Application SHOULD ignore the "Range" header field
        return $resource->set('process_range', false);
    }
}