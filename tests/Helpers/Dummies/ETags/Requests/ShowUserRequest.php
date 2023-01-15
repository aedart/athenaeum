<?php

namespace Aedart\Tests\Helpers\Dummies\ETags\Requests;

use Aedart\Contracts\ETags\Exceptions\ETagGeneratorException;
use Aedart\Contracts\ETags\HasEtag;
use Aedart\Contracts\ETags\Preconditions\ResourceContext;
use Aedart\ETags\Concerns\EloquentEtag;
use Aedart\ETags\Preconditions\Evaluator;
use Aedart\ETags\Preconditions\Resources\GenericResource;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

/**
 * Show User Request
 *
 * FOR TESTING ONLY...
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\ETags\Requests
 */
class ShowUserRequest extends FormRequest
{
    /**
     * The requested resource
     *
     * @var ResourceContext
     */
    public ResourceContext $resource;

    /**
     * Returns validation rules for request
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            // N/A
        ];
    }

    /**
     * Adds after validation hooks
     *
     * @param  Validator  $validator
     *
     * @return void
     */
    public function withValidator(Validator $validator): void
    {
        // Acc. to RFC9110, evaluation of preconditions SHOULD be performed
        // after regular input validation...
        // @see https://httpwg.org/specs/rfc9110.html#when.to.evaluate
        $validator->after([$this, 'evaluatePreconditions']);
    }

    /**
     * Evaluates request's preconditions against resource
     *
     * @param  Validator  $validator
     *
     * @return void
     *
     * @throws ETagGeneratorException
     * @throws HttpExceptionInterface
     * @throws Throwable
     */
    public function evaluatePreconditions(Validator $validator): void
    {
        // 1) Find requested resource or fail. Wrap it inside a Resource Context
        $model = $this->findOrFailModel();
        $resource = new GenericResource(
            data: $model,
            etag: $model->getStrongEtag(),
            lastModifiedDate: $model->updated_at
        );

        // 2) Evaluate request's preconditions against resource...
        $this->resource = Evaluator::make($this)
            ->evaluate($resource);
    }

    /**
     * Finds requested model or fails
     *
     * @return Model & HasEtag
     */
    protected function findOrFailModel(): Model & HasEtag
    {
        $model = new class() extends Model implements HasEtag {
            use EloquentEtag;
        };

        return $model
            ->forceFill([
                'id' => 42,
                'name' => 'John Doe',
                'age' => 31,

                // Use a fixed date for tests...
                'updated_at' => Carbon::make('2023-01-15T16:13:23.000000Z')
            ]);
    }
}
