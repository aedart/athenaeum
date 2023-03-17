<?php

namespace Aedart\Http\Api\Requests\Resources;

use Aedart\Contracts\ETags\ETag;
use Aedart\Contracts\Http\Api\Requests\HasAuthorisationModel;
use Aedart\Contracts\Http\Api\Requests\Preconditions\CanDetermineEvaluation;
use Aedart\Http\Api\Requests\ValidatedApiRequest;
use DateTimeInterface;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

/**
 * Create Single Resource Request
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Api\Requests\Resources
 */
abstract class CreateSingleResourceRequest extends ValidatedApiRequest implements
    HasAuthorisationModel,
    CanDetermineEvaluation
{
    /**
     * @inheritdoc
     */
    public function authorize(): bool
    {
        return $this->allows('store', $this->authorisationModel());
    }

    /**
     * {@inheritdoc}
     *
     * @throws HttpExceptionInterface
     * @throws Throwable
     * @throws ValidationException
     */
    public function after(Validator $validator): void
    {
        // After received data has been validated, we can use it to evaluate evt. request
        // preconditions.
        $this->performRequestPreconditionsEvaluation(
            $validator->validated()
        );

        // Extend this to add additional business logic validation... etc
    }

    /**
     * Performs request preconditions evaluation, if supported
     *
     * @param array $data Received input data
     *
     * @return void
     *
     * @throws HttpExceptionInterface
     * @throws Throwable
     */
    public function performRequestPreconditionsEvaluation(array $data): void
    {
        if (!$this->mustEvaluatePreconditions()) {
            return;
        }

        // [...] a recipient cache or origin server MUST evaluate received request preconditions after
        // it has successfully performed its normal request checks and JUST BEFORE it would process the
        // request content (if any) or perform the action associated with the request method. [...]
        // @see https://httpwg.org/specs/rfc9110.html#when.to.evaluate

        $this->evaluateRequestPreconditions(
            record: $this->wrapData($data),
            etag: fn () => $this->generateEtag($data),
            lastModifiedDate: $this->generateLastModifiedDate($data)
        );
    }

    /**
     * Wraps the input data so it can be used by preconditions evaluator
     *
     * @param array $data Input data
     *
     * @return mixed
     */
    protected function wrapData(array $data): mixed
    {
        return $data;
    }

    /**
     * Returns an {@see ETag} for given data, if able to
     *
     * Applicable for "If-Match" and "If-None-Match" preconditions.
     *
     * @param array $data
     *
     * @return ETag|null
     */
    protected function generateEtag(array $data): ETag|null
    {
        // If you are able to generate an etag for the resource that is about to be
        // created, then overwrite this method...
        // E.g. return \Aedart\ETags\Facades\Generator::makeStrong($data);

        return null;
    }

    /**
     * Returns "last modified date" for given data, if able to
     *
     * Applicable for "If-Modified-Since" and "If-Unmodified-Since" preconditions
     *
     * @param array $data
     *
     * @return DateTimeInterface|null
     */
    protected function generateLastModifiedDate(array $data): DateTimeInterface|null
    {
        // Although a resource is not yet created, we can relatively safely assume that the
        // "last modified date" will be "now" (for a new Eloquent models).
        // @see \Illuminate\Database\Eloquent\Concerns\HasTimestamps::updateTimestamps

        return now();
    }
}
