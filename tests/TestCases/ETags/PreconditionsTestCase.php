<?php

namespace Aedart\Tests\TestCases\ETags;

use Aedart\Contracts\ETags\ETag;
use Aedart\Contracts\ETags\Preconditions\Actions as PreconditionActions;
use Aedart\Contracts\ETags\Preconditions\Evaluator as PreconditionsEvaluator;
use Aedart\Contracts\ETags\Preconditions\Precondition;
use Aedart\Contracts\ETags\Preconditions\ResourceContext;
use Aedart\ETags\Preconditions\Evaluator;
use Aedart\ETags\Preconditions\Resources\GenericResource;
use DateTimeInterface;
use Illuminate\Http\Request;

/**
 * Preconditions Test Case
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\TestCases\ETags
 */
abstract class PreconditionsTestCase extends ETagsTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Returns a new resource context
     *
     * @param  mixed  $data [optional] E.g. a record, Eloquent model, a file...etc
     * @param  ETag|callable|null  $etag  [optional]
     * @param  DateTimeInterface|null  $lastModifiedDate  [optional]
     * @param  int  $size  [optional] Size of resource. Applicable if supporting "If-Range" and "Range" requests.
     * @param  callable|null $determineStateChangeSuccess  [optional] Callback that determines if a state change
     *                                                     has already succeeded on the resource. Callback MUST
     *                                                     return a boolean value.
     * @param  string  $rangeUnit  [optional] Allowed or supported range unit, e.g. bytes.
     * @param  int  $maxRangeSets  [optional] Maximum allowed range sets.
     *
     * @return ResourceContext
     */
    public function makeResourceContext(
        mixed $data = [],
        ETag|callable|null $etag = null,
        DateTimeInterface|null $lastModifiedDate = null,
        int $size = 0,
        callable|null $determineStateChangeSuccess = null,
        string $rangeUnit = 'bytes',
        int $maxRangeSets = 5
    ): ResourceContext {
        return new GenericResource(
            data: $data,
            etag: $etag,
            lastModifiedDate: $lastModifiedDate,
            size: $size,
            determineStateChangeSuccess: $determineStateChangeSuccess,
            rangeUnit: $rangeUnit,
            maxRangeSets: $maxRangeSets
        );
    }

    /**
     * Returns a new request preconditions evaluator instance
     *
     * @param  Request $request
     * @param  string[]|Precondition[]  $preconditions  [optional]
     * @param  PreconditionActions|null  $actions  [optional]
     *
     * @return PreconditionsEvaluator
     */
    public function makeEvaluator($request, array $preconditions = [], PreconditionActions|null $actions = null): PreconditionsEvaluator
    {
        return Evaluator::make(
            $request,
            $preconditions,
            $actions
        );
    }
}
