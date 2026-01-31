<?php

namespace Aedart\Tests\Unit\Utils\Memory;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Utils\Memory;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * B3_TeraAndTebibyteTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Utils\Memory
 */
#[Group(
    'utils',
    'utils-memory',
    'utils-memory-unit',
    'utils-memory-unit-b3',
    'utils-memory-unit-terabyte',
    'utils-memory-unit-tebibyte',
)]
class B3_TeraAndTebibyteTest extends UnitTestCase
{
    /**
     * @return void
     */
    #[Test]
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
     * @return void
     */
    #[Test]
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
     * @return void
     */
    #[Test]
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
     * @return void
     */
    #[Test]
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
     * @return void
     */
    #[Test]
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
     * @return void
     */
    #[Test]
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
