<?php

namespace Aedart\Tests\Unit\Utils\Memory;

use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Utils\Memory;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * C1_ToUnitTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Utils\Memory
 */
#[Group(
    'utils',
    'utils-memory',
    'utils-memory-unit',
    'utils-memory-unit-c1',
    'utils-memory-unit-to',
)]
class C1_ToUnitTest extends UnitTestCase
{
    /*****************************************************************
     * Data Providers
     ****************************************************************/

    /**
     * Data provider
     *
     * @return array
     */
    public function valuesProvider(): array
    {
        return [
            // Bytes
            'B' => [ 'B', 48, 48 ],
            'byte' => [ 'byte', 2, 2 ],
            'bytes' => [ 'bytes', 608, 608 ],

            // kilobyte / kibibyte
            'k' => [ 'k', 2600, 2.6 ],
            'kb' => [ 'kb', 1480, 1.48 ],
            'kilobyte' => [ 'kilobyte', 48_000, 48.0 ],
            'Kilobytes' => [ 'Kilobytes', 62_000, 62.0 ],

            'ki' => [ 'ki', 3809, 3.72 ],
            'kib' => [ 'kib', 4096, 4.0 ],
            'KIBIBYTE' => [ 'KIBIBYTE', 56_320, 55.0 ],
            'kibibytes' => [ 'kibibytes', 12_288, 12.0 ],

            // megabyte / mebibyte
            'm' => [ 'm', 1_000_000, 1.0 ],
            'mb' => [ 'mb', 2_000_000, 2.0 ],
            'megabyte' => [ 'megabyte', 3_000_000, 3.0 ],
            'megabytes' => [ 'megabytes', 9_000_000, 9.0 ],

            'mi' => [ 'mi', 1_048_576, 1.0 ],
            'mib' => [ 'mib', 2_097_152, 2.0 ],
            'mebibyte' => [ 'mebibyte', 3_145_728, 3.0 ],
            'mebibytes' => [ 'mebibytes', 8_388_608, 8.0 ],

            // gigabyte / gibibyte
            'g' => [ 'g', 1_100_000_000, 1.1 ],
            'gb' => [ 'gb', 2_000_000_000, 2.0 ],
            'gigabyte' => [ 'gigabyte', 5_340_000_000, 5.34 ],
            'gigabytes' => [ 'gigabytes', 3_000_000_000, 3.0 ],

            'gi' => [ 'gi', 1_181_116_006, 1.1 ],
            'gib' => [ 'gib', 2_147_483_648, 2.0 ],
            'gibibyte' => [ 'gibibyte', 5_690_831_667, 5.3 ],
            'gibibytes' => [ 'gibibytes', 3_221_225_472, 3.0 ],

            // terabyte / tebibyte
            't' => [ 't', 2_000_000_000_000, 2.0 ],
            'tb' => [ 'tb', 1_130_000_000_000, 1.13 ],
            'terabyte' => [ 'terabyte', 8_000_000_000_000, 8.0 ],
            'terabytes' => [ 'terabytes', 5_000_000_000_000, 5.0 ],

            'ti' => [ 'ti', 2_199_023_255_552, 2.0 ],
            'tib' => [ 'tib', 1_242_448_139_387, 1.13 ],
            'tebibyte' => [ 'tebibyte', 8_796_093_022_208, 8.0 ],
            'tebibytes' => [ 'tebibytes', 5_497_558_138_880, 5.0 ],

            // petabyte / pebibyte
            'p' => [ 'p', 1_500_000_000_000_000, 1.5 ],
            'pb' => [ 'pb', 2_350_000_000_000_000, 2.35 ],
            'petabyte' => [ 'petabyte', 1_000_000_000_000_000, 1.0 ],
            'petabytes' => [ 'petabytes', 3_000_000_000_000_000, 3.0 ],

            'pi' => [ 'pi', 1_688_849_860_263_936, 1.5 ],
            'pib' => [ 'pib', 2_645_864_781_080_166, 2.35 ],
            'pebibyte' => [ 'pebibyte', 1_125_899_906_842_624, 1.0 ],
            'pebibytes' => [ 'pebibytes', 3_377_699_720_527_872, 3.0 ],

            // Exabyte / Exbibyte
            'e' => [ 'e', 2_330_000_000_000_000_000, 2.33 ],
            'eb' => [ 'eb', 1_000_000_000_000_000_000, 1.0 ],
            'exabyte' => [ 'exabyte', 4_300_000_000_000_000_000, 4.3 ],
            'exabytes' => [ 'exabytes', 1_800_000_000_000_000_000, 1.8 ],

            'ei' => [ 'ei', 2_686_307_105_733_953_536, 2.33 ],
            'EiB' => [ 'EiB', 1_152_921_504_606_846_976, 1.0 ],
            'EXBIBYTE' => [ 'EXBIBYTE', 4_957_562_469_809_441_792, 4.3 ],
            'exbibytes' => [ 'exbibytes', 2_075_258_708_292_324_608, 1.8 ],
        ];
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @param  string  $unit
     * @param  int  $bytes
     * @param  int|float  $expectedValue
     *
     * @return void
     */
    #[DataProvider('valuesProvider')]
    #[Test]
    public function canConvertFromBytesTo(string $unit, int $bytes, int|float $expectedValue): void
    {
        $memoryUnit = Memory::unit($bytes);

        $result = $memoryUnit->to($unit, 2);

        $this->assertSame($expectedValue, $result, sprintf('Incorrect %s bytes to "%s" conversion', $bytes, $unit));
    }
}
