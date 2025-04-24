<?php

namespace Aedart\Tests\Unit\Utils\Memory;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Utils\Memory;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * B1_KiloAndKibibyteTest
 *
 * @group utils
 * @group utils-memory
 * @group utils-memory-unit
 * @group utils-memory-unit-b0
 * @group utils-memory-unit-kilobyte
 * @group utils-memory-unit-kibibyte
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Utils\Memory
 */
#[Group(
    'utils',
    'utils-memory',
    'utils-memory-unit',
    'utils-memory-unit-b0',
    'utils-memory-unit-kilobyte',
    'utils-memory-unit-kibibyte',
)]
class B0_KiloAndKibibyteTest extends UnitTestCase
{
    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function canCreateFromKilobyte()
    {
        $value = 5;
        $expected = $value * 1000;
        $unit = Memory::fromKilobyte($value);
        $result = $unit->bytes();

        ConsoleDebugger::output([
            'value' => $value,
            'bytes' => $result
        ]);

        $this->assertSame($expected, $result);
    }

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function canCreateFromLegacyKilobyte()
    {
        $value = 5;
        $expected = $value * 1024;
        $unit = Memory::fromLegacyKilobyte($value);
        $result = $unit->bytes();

        ConsoleDebugger::output([
            'value' => $value,
            'bytes' => $result
        ]);

        $this->assertSame($expected, $result);
    }

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function canCreateFromKibibyte()
    {
        $value = 5;
        $expected = $value * 1024;
        $unit = Memory::fromKibibyte($value);
        $result = $unit->bytes();

        ConsoleDebugger::output([
            'value' => $value,
            'bytes' => $result
        ]);

        $this->assertSame($expected, $result);
    }

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function canConvertToKilobyte()
    {
        $bytes = 2 * 1000;
        $unit = Memory::unit($bytes);
        $result = $unit->toKilobyte();

        ConsoleDebugger::output([
            'bytes' => $bytes,
            'kB' => $result
        ]);

        $this->assertSame(2.0, $result);
    }

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function canConvertToLegacyKilobyte()
    {
        $bytes = 5 * 1024;
        $unit = Memory::unit($bytes);
        $result = $unit->toLegacyKilobyte();

        ConsoleDebugger::output([
            'bytes' => $bytes,
            'kB (KiB)' => $result
        ]);

        $this->assertSame(5.0, $result);
    }

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function canConvertToKibibyte()
    {
        $bytes = 3 * 1024;
        $unit = Memory::unit($bytes);
        $result = $unit->toKibibyte();

        ConsoleDebugger::output([
            'bytes' => $bytes,
            'KiB' => $result
        ]);

        $this->assertSame(3.0, $result);
    }
}
