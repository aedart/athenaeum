<?php

namespace Aedart\Http\Api\Requests\Resources;

use Aedart\Http\Api\Requests\Concerns;
use Aedart\Http\Api\Requests\ValidatedApiRequest;
use Illuminate\Contracts\Validation\Validator;

/**
 * Show Single Resource Request
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Api\Requests\Resources
 */
abstract class ShowSingleResourceRequest extends ValidatedApiRequest
{
    use Concerns\SingleRecord;

    /**
     * @inheritdoc
     */
    protected bool $withRouteParameters = true;

    /**
     * @inheritDoc
     */
    public function authorizeAfterValidation(): bool
    {
        return $this->allows('show', $this->record);
    }

    /**
     * @inheritDoc
     */
    public function prepareForAfterValidation(Validator $validator): void
    {
        $this->prepareRecord($validator);

        parent::prepareForAfterValidation($validator);
    }
}