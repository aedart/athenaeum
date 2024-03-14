<?php

namespace Aedart\Tests\Unit\Utils\Random;

use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Utils\Random\Factory;
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
class FactoryTest extends UnitTestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function returnsRandomizerWithDefaultEngine(): void
    {
        $randomizer = Factory::make();

        $this->assertNotNull($randomizer->driver()->engine);
    }

    /**
     * @test
     *
     * @return void
     */
    public function returnsRandomizerWithSpecifiedEngine(): void
    {
        $engine = new Mt19937();
        $randomizer = Factory::make($engine);

        $this->assertSame($engine, $randomizer->driver()->engine);
    }
}
