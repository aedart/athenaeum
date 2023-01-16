<?php

namespace Aedart\Http\Api\Requests\Concerns;

use Aedart\Contracts\ETags\ETag;
use Aedart\Contracts\ETags\Preconditions\Actions as PreconditionActions;
use Aedart\Contracts\ETags\Preconditions\Evaluator as PreconditionsEvaluator;
use Aedart\Contracts\ETags\Preconditions\Precondition;
use Aedart\Contracts\ETags\Preconditions\ResourceContext;
use Aedart\ETags\Preconditions\Evaluator;
use Aedart\ETags\Preconditions\Resources\GenericResource;
use DateTimeInterface;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

/**
 * Concerns Http Conditionals
 *
 * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Conditional_requests
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Api\Requests\Concerns
 */
trait HttpConditionals
{
    /**
     * The resource context that has been evaluated
     * against requested preconditions
     *
     * @var ResourceContext|null
     */
    public ResourceContext|null $resource;

    /**
     * Allowed or supported range unit
     *
     * @see https://httpwg.org/specs/rfc9110.html#range.units
     *
     * @var string
     */
    protected string $allowedRangeUnit = 'bytes';

    /**
     * Maximum allowed range sets.
     *
     * @see https://httpwg.org/specs/rfc9110.html#rule.ranges-specifier
     *
     * @var int
     */
    protected int $maximumRangeSets = 5;

    /**
     * Evaluates request's preconditions for the given resource
     *
     * @param  mixed  $record E.g. an Eloquent record
     * @param  ETag|null  $etag  [optional] E.g. record's etag
     * @param  DateTimeInterface|null  $lastModifiedDate  [optional] E.g. records last modified date
     *
     * @return ResourceContext
     *
     * @throws HttpExceptionInterface
     * @throws Throwable
     */
    public function evaluateRequestPreconditions(
        mixed $record,
        ETag|null $etag = null,
        DateTimeInterface|null $lastModifiedDate = null
    ): ResourceContext {
        // Wrap given record or data into a resource context
        $resource = $this->wrapIntoResourceContext($record, $etag, $lastModifiedDate);

        // Evaluate evt. requested preconditions...
        return $this->resource = $this
            ->makePreconditionsEvaluator()
            ->evaluate($resource);
    }

    /**
     * Wraps record into a resource context for precondition evaluation
     *
     * @param  mixed  $record E.g. an Eloquent record
     * @param  ETag|null  $etag  [optional] E.g. record's etag
     * @param  DateTimeInterface|null  $lastModifiedDate  [optional] E.g. records last modified date
     *
     * @return ResourceContext
     */
    public function wrapIntoResourceContext(
        mixed $record,
        ETag|null $etag = null,
        DateTimeInterface|null $lastModifiedDate = null
    ): ResourceContext {
        return new GenericResource(
            data: $record,
            etag: $etag,
            lastModifiedDate: $lastModifiedDate,
            size: $this->determineSizeOf($record),
            determineStateChangeSuccess: [$this, 'hasStateChangeAlreadySucceeded'],
            rangeUnit: $this->allowedRangeUnit,
            maxRangeSets: $this->maximumRangeSets
        );
    }

    /**
     * Determine the size of given record or data
     *
     * @param mixed $data E.g. file path, content or stream...etc
     *
     * @return int If 0 (zero) is returned, then "Range" request is not supported
     */
    public function determineSizeOf(mixed $data): int
    {
        // Overwrite this method when your request supports "If-Range" / "Range" fields
        // and return the size, e.g. in bytes, for the given record or data.

        return 0;
    }

    /**
     * Determine if state change has already succeeded for resource.
     *
     * This method is applied for "If-Match" or "If-Unmodified-Since" preconditions,
     * when they are evaluated to false...
     *
     * @see \Aedart\Contracts\ETags\Preconditions\ResourceContext::hasStateChangeAlreadySucceeded
     *
     * @param \Illuminate\Http\Request $request
     * @param ResourceContext $resource
     *
     * @return bool
     */
    public function hasStateChangeAlreadySucceeded($request, ResourceContext $resource): bool
    {
        return false;
    }

    /**
     * Returns a new preconditions evaluator instance
     *
     * @return PreconditionsEvaluator
     */
    public function makePreconditionsEvaluator(): PreconditionsEvaluator
    {
        return Evaluator::make(
            request: $this,
            preconditions: $this->supportedPreconditionsList(),
            actions: $this->preconditionActions()
        );
    }

    /**
     * Returns precondition actions
     *
     * @return PreconditionActions|null
     */
    public function preconditionActions(): PreconditionActions|null
    {
        // Return null if "default" actions are to be used by
        // the evaluator. However, you are encouraged to create
        // actions that specific for your application / request.
        // @see \Aedart\ETags\Preconditions\Actions\DefaultActions

        return null;
    }

    /**
     * Returns list of supported preconditions for this request
     *
     * @return string[]|Precondition[]
     */
    public function supportedPreconditionsList(): array
    {
        // Return an empty array, if default evaluator's default
        // preconditions should be supported.
        // @see \Aedart\ETags\Preconditions\Evaluator::getDefaultPreconditions

        return [];
    }
}
