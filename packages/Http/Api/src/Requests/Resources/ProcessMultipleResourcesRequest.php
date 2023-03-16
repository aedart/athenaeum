<?php

namespace Aedart\Http\Api\Requests\Resources;

use Aedart\Contracts\Http\Api\Requests\HasAuthorisationModel;
use Aedart\Http\Api\Requests\Concerns;
use Aedart\Http\Api\Requests\ValidatedApiRequest;
use Illuminate\Contracts\Validation\Validator;
use Throwable;

/**
 * Process Multiple Resources Request
 *
 * Request abstraction for processing multiple existing resources.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Api\Requests\Resources
 */
abstract class ProcessMultipleResourcesRequest extends ValidatedApiRequest implements HasAuthorisationModel
{
    use Concerns\MultipleRecords;

    /**
     * Minimum amount of requested "targets"
     *
     * @var int
     */
    protected int $min = 1;

    /**
     * Maximum amount of requested "targets"
     *
     * @var int
     */
    protected int $max = 10;

    /**
     * @inheritdoc
     */
    protected function prepareForValidation()
    {
        parent::prepareForValidation();

        // Overwrite this method to configure additional request behaviour,
        // e.g. $this->with([ ... ]) relations to eager load, ...etc

        $this->configureValuesToAccept();
    }

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        $key = $this->targetsKey();

        return array_merge(parent::rules(), [
            $key => [
                'bail',
                'required',
                'array',
                "min:{$this->min}",
                "max:{$this->max}"
            ],

            "{$key}.*" => function () {
                return $this->targetIdentifierRules();
            },
        ]);
    }

    /**
     * {@inheritDoc}
     *
     * @throws Throwable
     */
    public function after(Validator $validator): void
    {
        parent::after($validator);

        // Obtain the requested targets (identifiers) and find matching records
        $key = $this->targetsKey();
        $targets = $validator->validated()[$key] ?? [];

        $this->findAndPrepareRecords($targets, $this->authorisationModel());
    }
}
