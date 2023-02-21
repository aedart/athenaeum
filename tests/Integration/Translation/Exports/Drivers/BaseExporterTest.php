<?php

namespace Aedart\Tests\Integration\Translation\Exports\Drivers;

use Aedart\Contracts\Translation\Exports\Exceptions\ProfileNotFoundException;
use Aedart\Contracts\Translation\Exports\Exporter;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Translation\TranslationTestCase;
use Illuminate\Contracts\Translation\Loader;

/**
 * BaseExporterTest
 *
 * @group translations
 * @group translations-exporter
 * @group translations-exporter-drivers
 * @group translations-exporter-drivers-base
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Translation\Exports\Drivers
 */
class BaseExporterTest extends TranslationTestCase
{
    /*****************************************************************
     * helpers
     ****************************************************************/

    /**
     * Returns exporter instance
     *
     * @param array $options [optional]
     *
     * @return Exporter
     *
     * @throws ProfileNotFoundException
     */
    public function exporter(array $options = []): Exporter
    {
        return $this->makeExporter('null', $options);
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
    public function hasTranslationsLoader(): void
    {
        $loader = $this->exporter()->getTranslationLoader();

        $this->assertInstanceOf(Loader::class, $loader);
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws ProfileNotFoundException
     */
    public function canDetectLocals(): void
    {
        $locales = $this->exporter()->detectLocals();

        ConsoleDebugger::output($locales);

        $this->assertGreaterThanOrEqual(1, $locales);
        $this->assertTrue(in_array('en', $locales), 'en locale not detected');
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws ProfileNotFoundException
     */
    public function hasDefaultPaths(): void
    {
        // TODO: ...uhm, what about the default paths...

        $paths = $this->exporter()->getPaths();

        ConsoleDebugger::output($paths);
    }
}