<?php

namespace Aedart\Tests\Unit\Utils\Memory;

use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Utils\Memory;
use Aedart\Utils\Memory\Unit;
use Codeception\Attribute\Group;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;

/**
 * A0_MemoryUnitTest
 *
 * @group utils
 * @group utils-memory
 * @group utils-memory-unit
 * @group utils-memory-unit-a0
 * @group utils-memory-unit-bytes
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Utils\Memory
 */
#[Group(
    'utils',
    'utils-memory',
    'utils-memory-unit',
    'utils-memory-unit-a0',
    'utils-memory-unit-bytes',
)]
class A0_MemoryUnitTest extends UnitTestCase
{
    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function canCreateMemoryUnit()
    {
        $unit = Memory::unit();

        $this->assertInstanceOf(Unit::class, $unit);
    }

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function canObtainBytes()
    {
        $bytes = 3;
        $unit = Memory::unit($bytes);

        $this->assertSame($bytes, $unit->bytes());
    }

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function failsWhenNegativeBytesProvided()
    {
        $this->expectException(InvalidArgumentException::class);

        $bytes = -3;
        Memory::unit($bytes);
    }
}
