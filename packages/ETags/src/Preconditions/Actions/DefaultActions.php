<?php

namespace Aedart\ETags\Preconditions\Actions;

use Aedart\Contracts\ETags\Preconditions\Actions;
use Aedart\Contracts\ETags\Preconditions\ResourceContext;
use Symfony\Component\HttpKernel\Exception\HttpException;
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