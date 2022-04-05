<?php

namespace Aedart\Tests\Unit\Utils\Memory;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Utils\Memory;

/**
 * X0_FormatTest
 *
 * @group utils
 * @group utils-memory
 * @group utils-memory-unit-x0
 * @group utils-memory-unit-format
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Utils\Memory
 */
class X0_FormatTest extends UnitTestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function canFormatUsingBinaryUnits()
    {
        $unit = Memory::fromMegabyte(3.1999);

        $result = $unit->binaryFormat();

        ConsoleDebugger::output($result);

        $this->assertSame('3.1 MiB', $result);
    }

    /**
     * @test
     *
     * @return void
     */
    public function canFormatUsingBinaryUnitsLongFormat()
    {
        $unit = Memory::fromMegabyte(3.1999);

        $result = $unit->binaryFormat(1, false);

        ConsoleDebugger::output($result);

        $this->assertSame('3.1 Mebibytes', $result);
    }

    /**
     * @test
     *
     * @return void
     */
    public function canFormatUsingDecimalUnits()
    {
        $unit = Memory::fromMegabyte(3.1999);

        $result = $unit->decimalFormat();

        ConsoleDebugger::output($result);

        $this->assertSame('3.2 MB', $result);
    }

    /**
     * @test
     *
     * @return void
     */
    public function canFormatUsingDecimalUnitsLongFormat()
    {
        $unit = Memory::fromMegabyte(3.1999);

        $result = $unit->decimalFormat(1, false);

        ConsoleDebugger::output($result);

        $this->assertSame('3.2 Megabytes', $result);
    }

    /**
     * @test
     *
     * @return void
     */
    public function canFormatLegacy()
    {
        $unit = Memory::fromMegabyte(3.1999);

        $result = $unit->legacyFormat();

        ConsoleDebugger::output($result);

        $this->assertSame('3.1 MB', $result);
    }
}
