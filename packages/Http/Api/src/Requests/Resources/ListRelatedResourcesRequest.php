<?php

namespace Aedart\Http\Api\Requests\Resources;

use Aedart\Contracts\Http\Api\Requests\HasAuthorisationModel;
use Aedart\Http\Api\Requests\Concerns;
use Illuminate\Contracts\Validation\Validator;

/**
 * List Related Resources Request
 *
 * A request to list related resources, for the requested resource
 * Similar to Laravel's resource scoping...
 *
 * @see https://laravel.com/docs/9.x/controllers#restful-scoping-resource-routes
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Api\Requests\Resources
 */
abstract class ListRelatedResourcesRequest extends ShowSingleResourceRequest implements HasAuthorisationModel
{
    use Concerns\Pagination;
    use Concerns\Filtering;

    /**
     * @inheritDoc
     */
    public function authorize(): bool
    {
        // Index ability / permission for the related model

        return $this->allows('index', $this->authorisationModel());
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return $this->withPagination(
            parent::rules()
        );
    }

    /**
     * @inheritDoc
     */
    public function prepareForAfterValidation(Validator $validator): void
    {
        $this->preparePagination($validator);

        $this->prepareFilters($validator);

        parent::prepareForAfterValidation($validator);
    }

    /**
     * @inheritDoc
     */
    public function mustEvaluatePreconditions(): bool
    {
        // It is unfeasible to evaluate preconditions for a list of
        // related resources. The system would have to generate an etag
        // based on the following:
        // - request query string (e.g. filters + pagination)
        // - retrieved database results, e.g. record ids and timestamps
        //
        // Thus, almost the entire request processing has to complete,
        // before an etag can be generated for a list of resources, which
        // can be too expensive...

        return false;
    }
}
