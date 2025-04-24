<?php

namespace Aedart\Tests\Unit\Utils\Memory;

use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Utils\Memory;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * D0_AddSubtractTest
 *
 * @group utils
 * @group utils-memory
 * @group utils-memory-unit
 * @group utils-memory-unit-d0
 * @group utils-memory-unit-add
 * @group utils-memory-unit-subtract
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Utils\Memory
 */
#[Group(
    'utils',
    'utils-memory',
    'utils-memory-unit',
    'utils-memory-unit-d0',
    'utils-memory-unit-add',
    'utils-memory-unit-subtract',
)]
class D0_AddSubtractTest extends UnitTestCase
{
    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function canAddBytes()
    {
        $original = Memory::unit(1);
        $new = $original->add(1);

        $this->assertSame(2, $new->bytes());
        $this->assertNotSame($original, $new);
    }

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function canAddUnitValue()
    {
        $original = Memory::unit(10);
        $new = $original->add(
            Memory::unit(25)
        );

        $this->assertSame(35, $new->bytes());
        $this->assertNotSame($original, $new);
    }

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function canSubtractBytes()
    {
        $original = Memory::unit(8);
        $new = $original->subtract(4);

        $this->assertSame(4, $new->bytes());
        $this->assertNotSame($original, $new);
    }

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function canSubtractUnitValue()
    {
        $original = Memory::unit(10);
        $new = $original->subtract(
            Memory::unit(9)
        );

        $this->assertSame(1, $new->bytes());
        $this->assertNotSame($original, $new);
    }
}
