<?php

namespace Aedart\Tests\TestCases\Validation;

use Aedart\Support\Helpers\Validation\ValidatorFactoryTrait;
use Aedart\Testing\TestCases\LaravelTestCase;
use Aedart\Validation\Providers\ValidationServiceProvider;
use Illuminate\Contracts\Validation\Validator;

/**
 * Validation Test-Case
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\TestCases\Validation
 */
abstract class ValidationTestCase extends LaravelTestCase
{
    use ValidatorFactoryTrait;

    /*****************************************************************
     * Setup
     ****************************************************************/

    /**
     * {@inheritdoc}
     */
    protected function getPackageProviders($app)
    {
        return [
            ValidationServiceProvider::class
        ];
    }

    /*****************************************************************
     * Helper
     ****************************************************************/

    /**
     * Creates a new validator instance
     *
     * @param array $data
     * @param array $rules
     * @param array $messages [optional]
     * @param array $customAttributes [optional]
     *
     * @return Validator
     */
    public function validator(array $data, array $rules, array $messages = [], array $customAttributes = []): Validator
    {
        return $this->getValidatorFactory()->make($data, $rules, $messages, $customAttributes);
    }
}