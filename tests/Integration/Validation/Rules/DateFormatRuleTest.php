<?php

namespace Aedart\Tests\Integration\Validation\Rules;

use Aedart\Contracts\Utils\Dates\DateTimeFormats;
use Aedart\Tests\TestCases\Validation\ValidationTestCase;
use Aedart\Validation\Rules\DateFormat;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\ValidationException;

/**
 * DateFormatRuleTest
 *
 * @group validation
 * @group rules
 * @group date-format
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Validation\Rules
 */
class DateFormatRuleTest extends ValidationTestCase
{
    /*****************************************************************
     * Data Providers
     ****************************************************************/

    /**
     * Provides input that should pass validation
     *
     * @return string[][]
     */
    public static function validInput(): array
    {
        return [
            'single format' => [ '2023', [ 'Y' ] ],
            'multiple formats' => [ '2023-04-22', [ 'Y-m', 'Y-m-d' ] ],
            'RFC3339 EXTENDED ZULU (+00:00)' => [ '2023-03-23T07:36:14.000+00:00', [ DateTimeFormats::RFC3339_EXTENDED_ZULU ] ],
            'RFC3339 EXTENDED ZULU (Z)' => [ '2023-03-23T07:36:14.000Z', [ DateTimeFormats::RFC3339_EXTENDED_ZULU ] ],
            'RFC3339 EXTENDED ZULU (+02:00)' => [ '2023-03-23T07:36:14.000+02:00', [ DateTimeFormats::RFC3339_EXTENDED_ZULU ] ],
            'RFC3339 EXTENDED ZULU (-01:00)' => [ '2023-03-23T07:36:14.000-01:00', [ DateTimeFormats::RFC3339_EXTENDED_ZULU ] ],
        ];
    }

    /**
     * Provides input that should not pass validation
     *
     * @return string[][]
     */
    public static function invalidInput(): array
    {
        return [
            'not a string' => [ false, [ 'Y-m-d' ] ],
            'not numeric string' => [ 'abc', [ 'Y-m-d' ] ],
            'invalid date format' => [ '2023-27-01', [ 'Y-m-d' ] ],
        ];
    }

    /*****************************************************************
     * Helpers
     ****************************************************************/


    /**
     * Returns new validation rule instance
     *
     * @param string[] $formats
     *
     * @return ValidationRule
     */
    public function makeRule(array $formats): ValidationRule
    {
        return new DateFormat(...$formats);
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     * @dataProvider validInput
     *
     * @param mixed $input
     * @param string[] $formats
     *
     * @return void
     *
     * @throws ValidationException
     */
    public function passesOnValidInput(mixed $input, array $formats): void
    {
        $this->shouldPass($input, $this->makeRule($formats));
    }

    /**
     * @test
     * @dataProvider invalidInput
     *
     * @param mixed $input
     * @param string[] $formats
     *
     * @return void
     *
     * @throws ValidationException
     */
    public function failsOnInvalidInput(mixed $input, array $formats): void
    {
        $this->shouldNotPass($input, $this->makeRule($formats));
    }
}
