<?php

namespace Aedart\Tests\Unit\Utils\Dates;

use Aedart\Contracts\Utils\Dates\DateTimeFormats;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Group;
use Illuminate\Support\Carbon;
use PHPUnit\Framework\Attributes\Test;

/**
 * DateTimeFormatsTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Utils\Dates
 */
#[Group(
    'utils',
    'date',
    'datetime-formats',
)]
class DateTimeFormatsTest extends UnitTestCase
{
    public function formatsProvider(): array
    {
        return [
            'RFC3339 ZULU, using "Z"' => [
                DateTimeFormats::RFC3339_ZULU,
                '2005-08-15T15:52:01Z'
            ],
            'RFC3339 ZULU, using offset' => [
                DateTimeFormats::RFC3339_ZULU,
                '2005-08-15T15:52:01+01:00'
            ],
            'RFC3339 ZULU, using UTC offset' => [
                DateTimeFormats::RFC3339_ZULU,
                '2005-08-15T15:52:01-00:00'
            ],

            // ------------------------------------------------------------- //

            'RFC3339 EXTENDED ZULU, using "Z"' => [
                DateTimeFormats::RFC3339_EXTENDED_ZULU,
                '2005-08-15T15:52:01.123Z'
            ],
            'RFC3339 EXTENDED ZULU, using offset' => [
                DateTimeFormats::RFC3339_EXTENDED_ZULU,
                '2005-08-15T15:52:01.321+01:00'
            ],
            'RFC3339 EXTENDED ZULU, using UTC offset' => [
                DateTimeFormats::RFC3339_EXTENDED_ZULU,
                '2005-08-15T15:52:01.000-00:00'
            ],

            // ------------------------------------------------------------- //

            'ISO8601 EXPANDED' => [
                DateTimeFormats::ISO8601_EXPANDED,
                '+10191-07-26T08:59:52+01:00'
            ],

            // ------------------------------------------------------------- //

            'RFC9110 (Http Date)' => [
                DateTimeFormats::RFC9110,
                'Sun, 06 Nov 1994 08:49:37 GMT'
            ],
        ];
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @param string $format
     * @param string $dateStr
     *
     * @return void
     */
    #[DataProvider('formatsProvider')]
    #[Test]
    public function canCreateFromFormat(string $format, string $dateStr): void
    {
        // a) Determine if date string has specified format
        // $this->assertTrue(Carbon::hasFormat($dateStr, $format), 'Invalid format of date string'); // NOTE: Does not work for DateTimeFormats::ISO8601_EXPANDED

        // b) Attempt to create date instance... If it does not fail, all is good
        $date = Carbon::createFromFormat($format, $dateStr);
        $this->assertNotFalse($date, 'Something went really wrong. Parsing failed, but no exception thrown!');

        // Debug...
        ConsoleDebugger::output([
            'format' => $format,
            'input' => $dateStr,
            'date' => $date->toArray()
        ]);
    }
}
