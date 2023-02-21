<?php

namespace Aedart\Tests\Integration\Translation\Exports\Drivers;

use Aedart\Contracts\Translation\Exports\Exceptions\ExporterException;
use Aedart\Contracts\Translation\Exports\Exceptions\ProfileNotFoundException;
use Aedart\Contracts\Translation\Exports\Exporter;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Translation\TranslationTestCase;
use Aedart\Translation\Exports\Drivers\ArrayExporter;

/**
 * ArrayExporterTest
 *
 * @group translations
 * @group translations-exporter
 * @group translations-exporter-drivers
 * @group translations-exporter-drivers-array
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Translation\Exports\Drivers
 */
class ArrayExporterTest extends TranslationTestCase
{
    /*****************************************************************
     * helpers
     ****************************************************************/

    /**
     * Returns exporter instance
     *
     * @param array $options [optional]
     *
     * @return Exporter|ArrayExporter
     *
     * @throws ProfileNotFoundException
     */
    public function exporter(array $options = []): Exporter|ArrayExporter
    {
        return $this->makeExporter('default', $options);
    }

    /*****************************************************************
     * Actual tests
     ****************************************************************/

    /**
     * @test
     *
     * @return void
     *
     * @throws ProfileNotFoundException
     */
    public function canObtainExporter(): void
    {
        $exporter = $this->exporter();

        $this->assertInstanceOf(ArrayExporter::class, $exporter);
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws ProfileNotFoundException
     * @throws ExporterException
     */
    public function canExport(): void
    {
        $translations = $this->exporter()->export();

        ConsoleDebugger::output($translations);

        // TODO: Incomplete...
        $this->markTestIncomplete('Implementation not ready');
    }
}
