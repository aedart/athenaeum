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
        $eTag = Generator::make(1234);

        ConsoleDebugger::output((string) $eTag);

        $this->assertInstanceOf(ETag::class, $eTag);
    }

    /**
     * @test
     *
     * @return void
     */
    public function canObtainDifferentGeneratorProfile(): void
    {
        $generator = Generator::profile('model');

        $this->assertInstanceOf(GeneratorInterface::class, $generator);
    }
}