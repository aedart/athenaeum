<?php

namespace Aedart\Tests\TestCases\Validation;

use Aedart\Support\Helpers\Validation\ValidatorFactoryTrait;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\LaravelTestCase;
use Aedart\Validation\Providers\ValidationServiceProvider;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

/**
 * Validation Test-Case
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
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
    public function makeValidator(array $data, array $rules, array $messages = [], array $customAttributes = []): Validator
    {
        return $this->getValidatorFactory()->make($data, $rules, $messages, $customAttributes);
    }

    /**
     * Validate input using given validation rule, expect pass
     *
     * @param mixed $input
     * @param Rule|ValidationRule $rule
     *
     * @throws ValidationException
     */
    public function shouldPass(mixed $input, Rule|ValidationRule $rule): void
    {
        $validator = $this->makeValidator([ 'input' => $input ], [ 'input' => $rule ]);

        $this->assertNotEmpty($validator->validate(), 'Input failed validation');
    }

    /**
     * Validate input using given validation rule, expect not to pass
     *
     * @param mixed $input
     * @param Rule|ValidationRule $rule
     *
     * @throws ValidationException
     */
    public function shouldNotPass(mixed $input, Rule|ValidationRule $rule): void
    {
        $this->expectException(ValidationException::class);

        $validator = $this->makeValidator([ 'input' => $input ], [ 'input' => $rule ]);

        try {
            $validator->validate();
        } catch (ValidationException $e) {
            // For debugging error messages
            $errors = $validator->errors();

            ConsoleDebugger::output($errors->messages());

            throw $e;
        }
    }
}
