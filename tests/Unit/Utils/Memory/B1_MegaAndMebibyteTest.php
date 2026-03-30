<?php

namespace Aedart\Tests\Unit\Utils\Memory;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Utils\Memory;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * B1_MegaAndMebibyteTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Utils\Memory
 */
#[Group(
    'utils',
    'utils-memory',
    'utils-memory-unit',
    'utils-memory-unit-b1',
    'utils-memory-unit-megabyte',
    'utils-memory-unit-mebibyte',
)]
class B1_MegaAndMebibyteTest extends UnitTestCase
{
    /**
     * @return void
     */
    #[Test]
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
     * @return void
     */
    #[Test]
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
     * @return void
     */
    #[Test]
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
     * @return void
     */
    #[Test]
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
     * @return void
     */
    #[Test]
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
     * @return void
     */
    #[Test]
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
