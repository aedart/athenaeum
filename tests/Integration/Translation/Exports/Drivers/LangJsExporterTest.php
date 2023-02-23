<?php

namespace Aedart\Tests\Integration\Translation\Exports\Drivers;

use Aedart\Contracts\Translation\Exports\Exceptions\ExporterException;
use Aedart\Contracts\Translation\Exports\Exceptions\ProfileNotFoundException;
use Aedart\Contracts\Translation\Exports\Exporter;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Translation\TranslationTestCase;
use Aedart\Translation\Exports\Drivers\LangJsExporter;

/**
 * LangJsExporterTest
 *
 * @group translations
 * @group translations-exporter
 * @group translations-exporter-drivers
 * @group translations-exporter-drivers-lang-js
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Translation\Exports\Drivers
 */
class LangJsExporterTest extends TranslationTestCase
{
    /*****************************************************************
     * helpers
     ****************************************************************/

    /**
     * Returns exporter instance
     *
     * @param array $options [optional]
     *
     * @return Exporter|LangJsExporter
     *
     * @throws ProfileNotFoundException
     */
    public function exporter(array $options = []): Exporter|LangJsExporter
    {
        return $this->makeExporter('lang_js', $options);
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

        $this->assertInstanceOf(LangJsExporter::class, $exporter);
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

        // -----------------------------------------------------------------------------//

        $this->assertNotEmpty($translations, 'No translations exported');

        // Not testing entire content, just a few high-level groups...
        $this->assertArrayHasKey('en.__JSON__', $translations);
        $this->assertArrayHasKey('en.auth', $translations);
        $this->assertArrayHasKey('en.pagination', $translations);
        $this->assertArrayHasKey('en.passwords', $translations);
        $this->assertArrayHasKey('en.validation', $translations);
        $this->assertArrayHasKey('en.athenaeum-http-api::api-resources', $translations);
        $this->assertArrayHasKey('en.translation-test::users', $translations);

        $this->assertArrayHasKey('da.__JSON__', $translations);
        $this->assertArrayHasKey('da.translation-test::users', $translations);

        $this->assertArrayHasKey('en-uk.__JSON__', $translations);
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws ExporterException
     * @throws ProfileNotFoundException
     */
    public function canExportSpecificLocaleAndGroups(): void
    {
        $translations = $this->exporter()->export(
            locales: 'en',
            groups: [
                'auth',
                'translation-test::users'
            ]
        );

        ConsoleDebugger::output($translations);

        // -----------------------------------------------------------------------------//

        $this->assertNotEmpty($translations, 'No translations exported');

        $this->assertArrayHasKey('en.__JSON__', $translations);
        $this->assertArrayHasKey('en.auth', $translations);
        $this->assertArrayHasKey('en.translation-test::users', $translations);

        $this->assertArrayNotHasKey('en.pagination', $translations);
        $this->assertArrayNotHasKey('en.passwords', $translations);
        $this->assertArrayNotHasKey('en.validation', $translations);
        $this->assertArrayNotHasKey('da.__JSON__', $translations);
        $this->assertArrayNotHasKey('da.translation-test::users', $translations);
        $this->assertArrayNotHasKey('en-uk.__JSON__', $translations);
    }
}
