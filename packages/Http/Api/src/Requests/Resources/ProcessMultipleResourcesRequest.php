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
     * @inheritDoc
     */
    public function rules(): array
    {
        $key = $this->targetsKey();

        return array_merge(parent::rules(), [
            $key => [
                'required',
                'array',
                "min:{$this->min}",
                "max:{$this->max}"
            ],

            "{$key}.*" => $this->identifiersRules(),
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

        $this->findAndPrepareRecords($validator, $this->authorisationModel());
    }
}
