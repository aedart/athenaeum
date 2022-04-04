<?php

namespace Aedart\Tests\Unit\Utils\Memory;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Utils\Memory;
use InvalidArgumentException;

/**
 * C0_ParseTest
 *
 * @group utils
 * @group utils-memory
 * @group utils-memory-unit
 * @group utils-memory-unit-c0
 * @group utils-memory-unit-parse
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Utils\Memory
 */
class C0_ParseTest extends UnitTestCase
{
    /*****************************************************************
     * Data Providers
     ****************************************************************/

    /**
     * Values data provider
     *
     * @return array[]
     */
    public function valuesProvider(): array
    {
        return [
            // Byte
            '48 B' => [ '48 B', 48 ],
            '1byte' => [ '1byte', 1 ],
            '603 bytes' => [ '603 bytes', 603 ],

            // kilobyte / kibibyte
            '2.6k' => [ '2.6k', 2600 ],
            '1.48 kb' => [ '1.48 kb', 1480 ],
            '48kilobyte' => [ '48kilobyte', 48_000 ],
            '62 Kilobytes' => [ '62 Kilobytes', 62_000 ],

            '3.72ki' => [ '3.72ki', 3809 ],
            '4 kib' => [ '4 kib', 4096 ],
            '55 KIBIBYTE' => [ '55 KIBIBYTE', 56_320 ],
            '12kibibytes' => [ '12kibibytes', 12_288 ],

            // megabyte / mebibyte
            '1 m' => [ '1 m', 1_000_000 ],
            '2 mb' => [ '2 mb', 2_000_000 ],
            '3 megabyte' => [ '3 megabyte', 3_000_000 ],
            '9megabytes' => [ '9megabytes', 9_000_000 ],

            '1 mi' => [ '1 mi', 1_048_576 ],
            '2 mib' => [ '2 mib', 2_097_152 ],
            '3 mebibyte' => [ '3 mebibyte', 3_145_728 ],
            '8mebibytes' => [ '8mebibytes', 8_388_608 ],

            // gigabyte / gibibyte
            '1.1 g' => [ '1.1 g', 1_100_000_000 ],
            '2 gb' => [ '2 gb', 2_000_000_000 ],
            '5.3 gigabyte' => [ '5.3 gigabyte', 5_300_000_000 ],
            '3gigabytes' => [ '3gigabytes', 3_000_000_000 ],

            '1.1 gi' => [ '1.1 gi', 1_181_116_006 ],
            '2 gib' => [ '2 gib', 2_147_483_648 ],
            '5.3 gibibyte' => [ '5.3 gibibyte', 5_690_831_667 ],
            '3gibibytes' => [ '3gibibytes', 3_221_225_472 ],
        ];
    }

    /*****************************************************************
     * Actual tests
     ****************************************************************/

    /**
     * @test
     * @dataProvider valuesProvider
     *
     * @param  string  $value
     * @param  int  $expectedBytes
     *
     * @return void
     */
    public function canParseStringValue(string $value, int $expectedBytes)
    {
        $unit = Memory::from($value);

        ConsoleDebugger::output([
            'string' => $value,
            'bytes' => $unit->bytes()
        ]);

        $this->assertSame($expectedBytes, $unit->bytes());
    }

    /**
     * @test
     *
     * @return void
     */
    public function failsWhenFormatIsInvalid()
    {
        $this->expectException(InvalidArgumentException::class);

        Memory::from('something-byte 123');
    }

    /**
     * @test
     *
     * @return void
     */
    public function failsWhenUnitIsKnown()
    {
        $this->expectException(InvalidArgumentException::class);

        Memory::from('1.5 åå');
    }
}
