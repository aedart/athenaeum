<?php

namespace Aedart\Tests\Unit\Utils\Memory;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Utils\Memory;

/**
 * B5_ExaAndExbibyteTest
 *
 * @group utils
 * @group utils-memory
 * @group utils-memory-unit
 * @group utils-memory-unit-b5
 * @group utils-memory-unit-exabyte
 * @group utils-memory-unit-exbibyte
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Utils\Memory
 */
class B5_ExaAndExbibyteTest extends UnitTestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function canCreateFromExabyte()
    {
        $value = 2;
        $expected = $value * pow(1000, 6);
        $unit = Memory::fromExabyte($value);
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
    public function canCreateFromExbibyte()
    {
        $value = 5;
        $expected = $value * pow(1024, 6);
        $unit = Memory::fromExbibyte($value);
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
    public function canConvertToExabyte()
    {
        $bytes = 2 * pow(1000, 6);
        $unit = Memory::unit($bytes);
        $result = $unit->toExabyte();

        ConsoleDebugger::output([
            'bytes' => $bytes,
            'EB' => $result
        ]);

        $this->assertSame(2.0, $result);
    }

    /**
     * @test
     *
     * @return void
     */
    public function canConvertToExbibyte()
    {
        $bytes = 3 * pow(1024, 6);
        $unit = Memory::unit($bytes);
        $result = $unit->toExbibyte();

        ConsoleDebugger::output([
            'bytes' => $bytes,
            'EiB' => $result
        ]);

        $this->assertSame(3.0, $result);
    }
}
