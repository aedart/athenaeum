<?php

namespace Aedart\ETags\Preconditions\Actions;

use Aedart\Contracts\ETags\Preconditions\Actions;
use Aedart\Contracts\ETags\Preconditions\ResourceContext;
use Aedart\ETags\Preconditions\Validators\Exceptions\RangeNotSatisfiable;
use Ramsey\Collection\CollectionInterface;
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
        // E.g. abort(response()->json(...));

        throw new HttpException(204);
    }

    /**
     * @inheritDoc
     */
    public function abortPreconditionFailed(ResourceContext $resource)
    {
        // E.g. abort(response()->json(...));

        throw new PreconditionFailedHttpException();
    }

    /**
     * @inheritDoc
     */
    public function abortNotModified(ResourceContext $resource)
    {
        // E.g. abort(response()->json(...));

        throw new HttpException(304);
    }

    /**
     * @inheritDoc
     */
    public function abortBadRequest(ResourceContext $resource, ?string $reason = null)
    {
        // E.g. abort(response()->json(...));

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
        // E.g. abort(response()->json(...));

        $reason = $reason ?? '';

        throw new RangeNotSatisfiable($range, $totalSize, $rangeUnit, $reason);
    }

    /**
     * @inheritDoc
     */
    public function processRange(ResourceContext $resource, CollectionInterface|null $ranges = null): mixed
    {
        return $resource->setRequestedRanges($ranges);
    }

    /**
     * @inheritDoc
     */
    public function ignoreRange(ResourceContext $resource): mixed
    {
        return $resource->setRequestedRanges(null);
    }
}