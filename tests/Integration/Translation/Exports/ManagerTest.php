<?php

namespace Aedart\Tests\Integration\Translation\Exports;

use Aedart\Contracts\Translation\Exports\Exceptions\ProfileNotFoundException;
use Aedart\Contracts\Translation\Exports\Exporter;
use Aedart\Contracts\Translation\Exports\Manager;
use Aedart\Tests\TestCases\Translation\TranslationTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * ManagerTest
 *
 * @group translations
 * @group translations-exporter
 * @group translations-exporter-manager
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Translation\Exports
 */
#[Group(
    'translations',
    'translations-exporter',
    'translations-exporter-manager',
)]
class ManagerTest extends TranslationTestCase
{
    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function canObtainInstance(): void
    {
        $manager = $this->getTranslationsExporterManager();

        $this->assertInstanceOf(Manager::class, $manager);
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws ProfileNotFoundException
     */
    #[Test]
    public function canMakeDefaultExporter(): void
    {
        $exporter = $this
            ->getTranslationsExporterManager()
            ->profile();

        $this->assertInstanceOf(Exporter::class, $exporter);
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
            ->getTranslationsExporterManager()
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
    public function returnsSameExporterInstance(): void
    {
        $manager = $this->getTranslationsExporterManager();

        $exporterA = $manager->profile();
        $exporterB = $manager->profile();

        $this->assertSame($exporterA, $exporterB);
    }
}
