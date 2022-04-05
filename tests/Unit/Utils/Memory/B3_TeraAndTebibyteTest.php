<?php

namespace Aedart\Tests\Unit\Utils\Memory;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Utils\Memory;

/**
 * B3_TeraAndTebibyteTest
 *
 * @group utils
 * @group utils-memory
 * @group utils-memory-unit
 * @group utils-memory-unit-b3
 * @group utils-memory-unit-terabyte
 * @group utils-memory-unit-tebibyte
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Utils\Memory
 */
class B3_TeraAndTebibyteTest extends UnitTestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function canCreateFromTerabyte()
    {
        $value = 2;
        $expected = $value * pow(1000, 4);
        $unit = Memory::fromTerabyte($value);
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
    public function canCreateFromLegacyTerabyte()
    {
        $value = 3;
        $expected = $value * pow(1024, 4);
        $unit = Memory::fromLegacyTerabyte($value);
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
    public function canCreateFromTebibyte()
    {
        $value = 5;
        $expected = $value * pow(1024, 4);
        $unit = Memory::fromTebibyte($value);
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
    public function canConvertToTerabyte()
    {
        $bytes = 2 * pow(1000, 4);
        $unit = Memory::unit($bytes);
        $result = $unit->toTerabyte();

        ConsoleDebugger::output([
            'bytes' => $bytes,
            'TB' => $result
        ]);

        $this->assertSame(2.0, $result);
    }

    /**
     * @test
     *
     * @return void
     */
    public function canConvertToLegacyTerabyte()
    {
        $bytes = 5 * pow(1024, 4);
        $unit = Memory::unit($bytes);
        $result = $unit->toLegacyTerabyte();

        ConsoleDebugger::output([
            'bytes' => $bytes,
            'TB (TiB)' => $result
        ]);

        $this->assertSame(5.0, $result);
    }

    /**
     * @test
     *
     * @return void
     */
    public function canConvertToTebibyte()
    {
        $bytes = 3 * pow(1024, 4);
        $unit = Memory::unit($bytes);
        $result = $unit->toTebibyte();

        ConsoleDebugger::output([
            'bytes' => $bytes,
            'TiB' => $result
        ]);

        $this->assertSame(3.0, $result);
    }
}
