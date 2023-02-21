<?php

namespace Aedart\Tests\Integration\Translation\Exports;

use Aedart\Contracts\Translation\Exports\Exceptions\ProfileNotFoundException;
use Aedart\Contracts\Translation\Exports\Exporter;
use Aedart\Contracts\Translation\Exports\Manager;
use Aedart\Tests\TestCases\Translation\TranslationTestCase;

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
class ManagerTest extends TranslationTestCase
{
    /**
     * @test
     *
     * @return void
     */
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
    public function failsWhenProfileNotFound():void
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
    public function returnsSameExporterInstance(): void
    {
        $manager = $this->getTranslationsExporterManager();

        $exporterA = $manager->profile();
        $exporterB = $manager->profile();

        $this->assertSame($exporterA, $exporterB);
    }
}