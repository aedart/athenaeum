<?php

namespace Aedart\Http\Api\Requests\Resources;

use Aedart\Contracts\ETags\Exceptions\ETagGeneratorException;
use Aedart\Contracts\Http\Api\Requests\Preconditions\CanDetermineEvaluation;
use Aedart\Http\Api\Requests\Concerns;
use Aedart\Http\Api\Requests\ValidatedApiRequest;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

/**
 * Show Single Resource Request
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Api\Requests\Resources
 */
abstract class ShowSingleResourceRequest extends ValidatedApiRequest implements CanDetermineEvaluation
{
    use Concerns\SingleRecord;

    /**
     * @inheritDoc
     */
    public function authorizeFoundRecord(Model $record): bool
    {
        return $this->allows('show', $record);
    }

    /**
     * {@inheritDoc}
     *
     * @throws Throwable
     */
    protected function prepareForValidation()
    {
        // Attempt to find and prepare requested record, before the validation
        // is applied. This allows certain rules, like `Rule::unique()->ignore()`
        // to be applied safely.

        $this->findAndPrepareRecord();
    }

    /**
     * {@inheritdoc}
     *
     * @throws ETagGeneratorException
     * @throws HttpExceptionInterface
     * @throws Throwable
     */
    public function whenRecordIsFound(Model $record): void
    {
        if (!$this->mustEvaluatePreconditions()) {
            return;
        }

        // [...] a recipient cache or origin server MUST evaluate received request preconditions after
        // it has successfully performed its normal request checks and JUST BEFORE it would process the
        // request content (if any) or perform the action associated with the request method. [...]
        // @see https://httpwg.org/specs/rfc9110.html#when.to.evaluate

        $this->evaluateRequestPreconditions(
            record: $record,
            etag: $this->getRecordEtag(),
            lastModifiedDate: $this->getRecordLastModifiedDate()
        );
    }
}
