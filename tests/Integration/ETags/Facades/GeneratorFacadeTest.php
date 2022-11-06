<?php

namespace Aedart\Tests\Integration\ETags\Facades;

use Aedart\Contracts\ETags\ETag;
use Aedart\Contracts\ETags\Generator as GeneratorInterface;
use Aedart\ETags\Facades\Generator;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\ETags\ETagsTestCase;

/**
 * GeneratorFacadeTest
 *
 * @group etags
 * @group etags-facades
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\ETags\Facades
 */
class GeneratorFacadeTest extends ETagsTestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function canMakeETagViaFacade(): void
    {
        $eTag = Generator::make('something');

        ConsoleDebugger::output((string) $eTag);

        $this->assertInstanceOf(ETag::class, $eTag);
    }

    /**
     * @test
     *
     * @return void
     */
    public function canMakeWeakETagViaFacade(): void
    {
        $eTag = Generator::makeWeak(1234);

        $this->assertInstanceOf(ETag::class, $eTag);
        $this->assertTrue($eTag->isWeak());

        ConsoleDebugger::output((string) $eTag);
    }

    /**
     * @test
     *
     * @return void
     */
    public function canMakeStrongETagViaFacade(): void
    {
        $eTag = Generator::makeStrong(1234);

        $this->assertInstanceOf(ETag::class, $eTag);
        $this->assertTrue($eTag->isStrong());

        ConsoleDebugger::output((string) $eTag);
    }

    /**
     * @test
     *
     * @return void
     */
    public function canObtainDifferentGeneratorProfile(): void
    {
        $generator = Generator::profile('other');

        $this->assertInstanceOf(GeneratorInterface::class, $generator);
    }
}