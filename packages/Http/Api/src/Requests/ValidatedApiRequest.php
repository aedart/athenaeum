<?php

namespace Aedart\Http\Api\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

/**
 * Validated Api Request
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Api\Requests
 */
abstract class ValidatedApiRequest extends FormRequest
{
    use Concerns\Authorisation;
    use Concerns\HttpConditionals;

    /**
     * Returns validation rules for this request
     *
     * @return array
     */
    public function rules(): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    protected function prepareForValidation()
    {
        // Validate route parameters, if required...
        // @see \Aedart\Http\Api\Requests\Concerns\RouteParametersValidation
        if (method_exists($this, 'validateRouteParameters')) {
            $this->validateRouteParameters();
        }
    }

    /**
     * Perform post request data validation, e.g. business logic validation
     *
     * @param Validator $validator
     *
     * @return void
     *
     * @throws ValidationException
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function afterValidation(Validator $validator): void
    {
        // Overwrite this method to add custom business logic validation.
        // E.g. complex record existence checks, more advanced cross field validation... etc.
    }

    /**
     * Prepare to run the {@see after} business logic validation
     *
     * @param  Validator  $validator
     *
     * @return void
     *
     * @throws ValidationException
     */
    public function prepareForAfterValidation(Validator $validator): void
    {
        // Determine if there are any validation errors at this point. If so,
        // then abort the request. There is no need to continue with more
        // complex business logic validation, when invalid data is detected.

        $failed = $validator->failed();

        if (!empty($failed)) {
            throw new ValidationException($validator);
        }
    }

    /**
     * Customises the request validator instance
     *
     * @param  Validator  $validator
     *
     * @return void
     */
    public function withValidator(Validator $validator)
    {
        $validator
            ->after([$this, 'prepareForAfterValidation'])
            ->after([$this, 'afterValidation']);
    }

    //    /**
    //     * @inheritDoc
    //     */
    //    public function validationData(): array
    //    {
    //        return parent::validationData();
    //    }

    /**
     * {@inheritDoc}
     *
     * @return \App\Models\User|\Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user($guard = null)
    {
        return parent::user($guard);
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * @inheritdoc
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    protected function passedValidation()
    {
        if (!$this->authorizeAfterValidation()) {
            $this->failedAuthorization();
        }
    }
}
