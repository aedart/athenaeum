<?php

namespace Aedart\Tests\Unit\Utils\Memory;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Utils\Memory;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * B4_PetaAndPebibyteTest
 *
 * @group utils
 * @group utils-memory
 * @group utils-memory-unit
 * @group utils-memory-unit-b4
 * @group utils-memory-unit-petabyte
 * @group utils-memory-unit-pebibyte
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Utils\Memory
 */
#[Group(
    'utils',
    'utils-memory',
    'utils-memory-unit',
    'utils-memory-unit-b4',
    'utils-memory-unit-petabyte',
    'utils-memory-unit-pebibyte',
)]
class B4_PetaAndPebibyteTest extends UnitTestCase
{
    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function canCreateFromPetabyte()
    {
        $value = 2;
        $expected = $value * pow(1000, 5);
        $unit = Memory::fromPetabyte($value);
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
    public function canCreateFromPebibyte()
    {
        $value = 5;
        $expected = $value * pow(1024, 5);
        $unit = Memory::fromPebibyte($value);
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
    public function canConvertToPetabyte()
    {
        $bytes = 2 * pow(1000, 5);
        $unit = Memory::unit($bytes);
        $result = $unit->toPetabyte();

        ConsoleDebugger::output([
            'bytes' => $bytes,
            'PB' => $result
        ]);

        $this->assertSame(2.0, $result);
    }

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function canConvertToPebibyte()
    {
        $bytes = 3 * pow(1024, 5);
        $unit = Memory::unit($bytes);
        $result = $unit->toPebibyte();

        ConsoleDebugger::output([
            'bytes' => $bytes,
            'PiB' => $result
        ]);

        $this->assertSame(3.0, $result);
    }
}
