<?php

namespace Aedart\Tests\Unit\Utils\Random;

use Aedart\Contracts\Utils\Random\Type;
use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Utils\Random\Factory;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;
use Random\Engine\Mt19937;

/**
 * FactoryTest
 *
 * @group utils
 * @group utils-random
 * @group utils-randomizer
 * @group utils-randomizer-factory
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\Unit\Utils\Random
 */
#[Group(
    'utils',
    'utils-random',
    'utils-randomizer',
    'utils-randomizer-factory',
)]
class FactoryTest extends UnitTestCase
{
    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function returnsRandomizerWithDefaultEngine(): void
    {
        $randomizer = Factory::make(Type::String);

        $this->assertNotNull($randomizer->driver()->engine);
    }

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function returnsRandomizerWithSpecifiedEngine(): void
    {
        $engine = new Mt19937();
        $randomizer = Factory::make(Type::Array, $engine);

        $this->assertSame($engine, $randomizer->driver()->engine);
    }
}
