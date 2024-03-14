<?php

namespace Aedart\Tests\Integration\Validation\Rules;

use Aedart\Tests\TestCases\Validation\ValidationTestCase;
use Aedart\Validation\Rules\AlphaDashDot;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * AlphaDashDotRuleTest
 *
 * @group validation
 * @group rules
 * @group alpha-dash-dot
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Validation\Rules
 */
class AlphaDashDotRuleTest extends ValidationTestCase
{
    /*****************************************************************
     * Data Providers
     ****************************************************************/

    /**
     * Provides input that should pass validation
     *
     * @return \string[][]
     */
    public function validInput(): array
    {
        return [
            'alpha numeric with dash' => [ 'some-slug_with-123' ],
            'alpha numeric with dot' => [ 'users.some-slug_with-123' ],
            'special language letters' => [ 'users.update-üæøåè' ],
            'without dash and dot' => [ 'users' ],
        ];
    }

    /**
     * Provides input that should not pass validation
     *
     * @return \string[][]
     */
    public function invalidInput(): array
    {
        return [
            'special symbols' => [ 'some-slug_with-@' ],
            'dot and special symbol' => [ 'users.some-slug_with-#' ],
        ];
    }

    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Creates new instance of validation rule
     *
     * @return ValidationRule
     */
    public function makeRule(): ValidationRule
    {
        return new AlphaDashDot();
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     * @dataProvider validInput
     *
     * @param mixed $input
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function passesOnValidInput(mixed $input): void
    {
        $this->shouldPass($input, $this->makeRule());
    }

    /**
     * @test
     * @dataProvider invalidInput
     *
     * @param mixed $input
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function failsOnInvalidInput(mixed $input): void
    {
        $this->shouldNotPass($input, $this->makeRule());
    }
}
