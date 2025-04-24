<?php

namespace Aedart\Tests\Unit\Utils\Memory;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Utils\Memory;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * B2_GigaAndGibibyteTest
 *
 * @group utils
 * @group utils-memory
 * @group utils-memory-unit
 * @group utils-memory-unit-b2
 * @group utils-memory-unit-gigabyte
 * @group utils-memory-unit-gibibyte
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Utils\Memory
 */
#[Group(
    'utils',
    'utils-memory',
    'utils-memory-unit',
    'utils-memory-unit-b2',
    'utils-memory-unit-gigabyte',
    'utils-memory-unit-gibibyte',
)]
class B2_GigaAndGibibyteTest extends UnitTestCase
{
    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function canCreateFromGigabyte()
    {
        $value = 2;
        $expected = $value * pow(1000, 3);
        $unit = Memory::fromGigabyte($value);
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
    public function canCreateFromLegacyGigabyte()
    {
        $value = 3;
        $expected = $value * pow(1024, 3);
        $unit = Memory::fromLegacyGigabyte($value);
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
    public function canCreateFromGibibyte()
    {
        $value = 5;
        $expected = $value * pow(1024, 3);
        $unit = Memory::fromGibibyte($value);
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
    public function canConvertToGigabyte()
    {
        $bytes = 2 * pow(1000, 3);
        $unit = Memory::unit($bytes);
        $result = $unit->toGigabyte();

        ConsoleDebugger::output([
            'bytes' => $bytes,
            'GB' => $result
        ]);

        $this->assertSame(2.0, $result);
    }

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function canConvertToLegacyGigabyte()
    {
        $bytes = 5 * pow(1024, 3);
        $unit = Memory::unit($bytes);
        $result = $unit->toLegacyGigabyte();

        ConsoleDebugger::output([
            'bytes' => $bytes,
            'GB (GiB)' => $result
        ]);

        $this->assertSame(5.0, $result);
    }

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function canConvertToGibibyte()
    {
        $bytes = 3 * pow(1024, 3);
        $unit = Memory::unit($bytes);
        $result = $unit->toGibibyte();

        ConsoleDebugger::output([
            'bytes' => $bytes,
            'GiB' => $result
        ]);

        $this->assertSame(3.0, $result);
    }
}
