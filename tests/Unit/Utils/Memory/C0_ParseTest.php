<?php

namespace Aedart\Tests\Unit\Utils\Memory;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Utils\Memory;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Group;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;

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
#[Group(
    'utils',
    'utils-memory',
    'utils-memory-unit',
    'utils-memory-unit-c0',
    'utils-memory-unit-parser',
)]
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

            // terabyte / tebibyte
            '2 t' => [ '2 t', 2_000_000_000_000 ],
            '1.13 tb' => [ '1.13 tb', 1_130_000_000_000 ],
            '8 terabyte' => [ '8 terabyte', 8_000_000_000_000 ],
            '5terabytes' => [ '5terabytes', 5_000_000_000_000 ],

            '2 ti' => [ '2 ti', 2_199_023_255_552 ],
            '1.13 tib' => [ '1.13 tib', 1_242_448_139_387 ],
            '8 tebibyte' => [ '8 tebibyte', 8_796_093_022_208 ],
            '5tebibytes' => [ '5tebibytes', 5_497_558_138_880 ],

            // petabyte / pebibyte
            '1.5 p' => [ '1.5 p', 1_500_000_000_000_000 ],
            '2.35 pb' => [ '2.35 pb', 2_350_000_000_000_000 ],
            '1 petabyte' => [ '1 petabyte', 1_000_000_000_000_000 ],
            '3petabytes' => [ '3petabytes', 3_000_000_000_000_000 ],

            '1.5 pi' => [ '1.5 pi', 1_688_849_860_263_936 ],
            '3 pib' => [ '3 pib', 3_377_699_720_527_872 ],
            '1 pebibyte' => [ '1 pebibyte', 1_125_899_906_842_624 ],
            '3pebibytes' => [ '3pebibytes', 3_377_699_720_527_872 ],

            // Exabyte / Exbibyte
            '2.33 e' => [ '2.33 e', 2_330_000_000_000_000_000 ],
            '1.0 eb' => [ '1.0 eb', 1_000_000_000_000_000_000 ],
            '4.3 exabyte' => [ '4.3 exabyte', 4_300_000_000_000_000_000 ],
            '1.8exabytes' => [ '1.8exabytes', 1_800_000_000_000_000_000 ],

            '2.33 ei' => [ '2.33 ei', 2_686_307_105_733_953_536 ],
            '1.0 EiB' => [ '1.0 EiB', 1_152_921_504_606_846_976 ],
            '4.3 EXBIBYTE' => [ '4.3 EXBIBYTE', 4_957_562_469_809_441_792 ],
            '1.8exbibytes' => [ '1.8exbibytes', 2_075_258_708_292_324_608 ],
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
    #[DataProvider('valuesProvider')]
    #[Test]
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
    #[Test]
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
    #[Test]
    public function failsWhenUnitIsKnown()
    {
        $this->expectException(InvalidArgumentException::class);

        Memory::from('1.5 åå');
    }
}
