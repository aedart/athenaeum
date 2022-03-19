<?php

namespace Aedart\Tests\Unit\Utils\Memory;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Utils\Memory;

/**
 * B1_MegaAndMebibyteTest
 *
 * @group utils
 * @group utils-memory
 * @group utils-memory-unit
 * @group utils-memory-unit-b1
 * @group utils-memory-unit-megabyte
 * @group utils-memory-unit-mebibyte
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Utils\Memory
 */
class B1_MegaAndMebibyteTest extends UnitTestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function canCreateFromMegabyte()
    {
        $value = 3;
        $expected = $value * 1000 * 1000;
        $unit = Memory::fromMegabyte($value);
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
    public function canCreateFromLegacyMegabyte()
    {
        $value = 4;
        $expected = $value * 1024 * 1024;
        $unit = Memory::fromLegacyMegabyte($value);
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
    public function canCreateFromMebibyte()
    {
        $value = 5;
        $expected = $value * 1024 * 1024;
        $unit = Memory::fromMebibyte($value);
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
    public function canConvertToMegabyte()
    {
        $bytes = 2 * 1000 * 1000;
        $unit = Memory::unit($bytes);
        $result = $unit->toMegabyte();

        ConsoleDebugger::output([
            'bytes' => $bytes,
            'MB' => $result
        ]);

        $this->assertSame(2.0, $result);
    }

    /**
     * @test
     *
     * @return void
     */
    public function canConvertToLegacyMegabyte()
    {
        $bytes = 5 * 1024 * 1024;
        $unit = Memory::unit($bytes);
        $result = $unit->toLegacyMegabyte();

        ConsoleDebugger::output([
            'bytes' => $bytes,
            'MB (MiB)' => $result
        ]);

        $this->assertSame(5.0, $result);
    }

    /**
     * @test
     *
     * @return void
     */
    public function canConvertToMebibyte()
    {
        $bytes = 3 * 1024 * 1024;
        $unit = Memory::unit($bytes);
        $result = $unit->toMebibyte();

        ConsoleDebugger::output([
            'bytes' => $bytes,
            'MiB' => $result
        ]);

        $this->assertSame(3.0, $result);
    }
}
