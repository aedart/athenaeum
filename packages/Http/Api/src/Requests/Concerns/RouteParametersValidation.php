<?php

namespace Aedart\Http\Api\Requests\Concerns;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Validator as ValidatorFacade;
use Illuminate\Validation\ValidationException;

/**
 * Concerns Route Parameters Validation
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Api\Requests\Concerns
 */
trait RouteParametersValidation
{
    /**
     * Validation rules for route parameters
     *
     * @return array
     */
    abstract public function routeParameterRules(): array;

    /**
     * Validates the route's parameters
     *
     * @see routeParameterRules()
     *
     * @return void
     *
     * @throws ValidationException
     */
    public function validateRouteParameters(): void
    {
        $rules = $this->routeParameterRules();
        if (empty($rules)) {
            return;
        }

        $validator = $this->makeRouteParametersValidator($rules);

        if ($validator->fails()) {
            $this->failInvalidRouteParameters($validator);
        }
    }

    /**
     * Fails due to invalid route parameters
     *
     * @param Validator $validator
     * @return never
     *
     * @throws ValidationException
     */
    protected function failInvalidRouteParameters(Validator $validator): never
    {
        throw new ValidationException($validator);
    }

    /**
     * Makes a new validator instance for the route parameters
     *
     * @param array $rules
     *
     * @return Validator
     */
    protected function makeRouteParametersValidator(array $rules): Validator
    {
        return ValidatorFacade::make(
            data: $this->route()->parameters(),
            rules: $rules
        );
    }
}
