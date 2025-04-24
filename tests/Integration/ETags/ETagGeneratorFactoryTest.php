<?php

namespace Aedart\Tests\Integration\ETags;

use Aedart\Contracts\ETags\ETag;
use Aedart\Contracts\ETags\Exceptions\ProfileNotFoundException;
use Aedart\Contracts\ETags\Factory;
use Aedart\Contracts\ETags\Generator;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\ETags\ETagsTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * ETagGeneratorFactoryTest
 *
 * @group etags
 * @group etags-generator-factory
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\ETags
 */
#[Group(
    'etags',
    'etags-generator-factory',
)]
class ETagGeneratorFactoryTest extends ETagsTestCase
{
    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function canObtainGeneratorFactory(): void
    {
        $factory = $this->getEtagGeneratorFactory();

        $this->assertNotNull($factory);
        $this->assertInstanceOf(Factory::class, $factory);
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws ProfileNotFoundException
     */
    #[Test]
    public function canMakeDefaultGenerator(): void
    {
        $generator = $this
            ->getEtagGeneratorFactory()
            ->profile();

        $this->assertInstanceOf(Generator::class, $generator);
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws ProfileNotFoundException
     */
    #[Test]
    public function failsWhenProfileNotFound(): void
    {
        $this->expectException(ProfileNotFoundException::class);

        $this
            ->getEtagGeneratorFactory()
            ->profile('unknown-profile');
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws ProfileNotFoundException
     */
    #[Test]
    public function canMakeGeneratorForProfile(): void
    {
        $generator = $this
            ->getEtagGeneratorFactory()
            ->profile('other');

        $this->assertInstanceOf(Generator::class, $generator);
    }

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function forwardsCallsToDefaultProfile(): void
    {
        $etag = $this->getEtagGeneratorFactory()->make(1234);

        ConsoleDebugger::output((string) $etag);

        $this->assertInstanceOf(ETag::class, $etag);
    }
}
