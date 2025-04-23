<?php

namespace Aedart\Tests\Integration\ETags\Facades;

use Aedart\Contracts\ETags\Collection;
use Aedart\Contracts\ETags\ETag;
use Aedart\Contracts\ETags\Generator as GeneratorInterface;
use Aedart\ETags\Facades\Generator;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\ETags\ETagsTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * GeneratorFacadeTest
 *
 * @group etags
 * @group etags-facade
 * @group facades
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\ETags\Facades
 */
#[Group(
    'etags',
    'etags-facade',
    'facades'
)]
class GeneratorFacadeTest extends ETagsTestCase
{
    /**
     * @test
     *
     * @return void
     */
    #[Test]
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
    #[Test]
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
    #[Test]
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
    #[Test]
    public function canObtainDifferentGeneratorProfile(): void
    {
        $generator = Generator::profile('other');

        $this->assertInstanceOf(GeneratorInterface::class, $generator);
    }

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function canParseMultipleEtagsFromHttpHeader(): void
    {
        $collection = Generator::parse('"15487",W/"r2d23574", W/"c3pio784",  W/"1234"');

        $this->assertInstanceOf(Collection::class, $collection);
        $this->assertCount(4, $collection);
    }
}
