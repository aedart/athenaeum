<?php

namespace Aedart\Tests\Helpers\Dummies\ETags\Requests;

use Aedart\Contracts\ETags\Exceptions\ETagGeneratorException;
use Aedart\Contracts\ETags\HasEtag;
use Aedart\Contracts\ETags\Preconditions\ResourceContext;
use Aedart\ETags\Concerns\EloquentEtag;
use Aedart\ETags\Preconditions\Evaluator;
use Aedart\ETags\Preconditions\Resources\GenericResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

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
     * @inheritdoc
     */
    protected function prepareForValidation()
    {
        // 1) Find requested resource or fail.
        $model = $this->findOrFailModel();

        // 2) Wrap it inside a Resource Context
        $resource = $this->makeResourceContext($model);

        // 3) Evaluate request's preconditions against resource...
        $this->resource = Evaluator::make($this)
            ->evaluate($resource);
    }

    /**
     * Wraps the model into a resource context
     *
     * @param  Model&HasEtag  $model
     *
     * @return ResourceContext
     *
     * @throws ETagGeneratorException
     */
    protected function makeResourceContext(Model & HasEtag $model): ResourceContext
    {
        return new GenericResource(
            data: $model,
            etag: $model->getStrongEtag(),
            lastModifiedDate: $model->updated_at
        );
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
