<?php

namespace Aedart\Http\Api\Requests\Resources;

use Aedart\Contracts\Http\Api\Requests\HasAuthorisationModel;
use Aedart\Http\Api\Requests\Concerns;
use Aedart\Http\Api\Requests\ValidatedApiRequest;
use Illuminate\Contracts\Validation\Validator;

/**
 * List Resources Request
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Api\Requests\Resources
 */
abstract class ListResourcesRequest extends ValidatedApiRequest implements HasAuthorisationModel
{
    use Concerns\Pagination;
    use Concerns\Filtering;

    /**
     * @inheritdoc
     */
    public function authorize(): bool
    {
        return $this->allows('index', $this->authorisationModel());
    }

    /**
     * @inheritDoc
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
}
