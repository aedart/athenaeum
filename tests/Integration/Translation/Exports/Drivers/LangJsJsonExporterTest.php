<?php

namespace Aedart\Tests\Integration\Translation\Exports\Drivers;

use Aedart\Contracts\Translation\Exports\Exceptions\ExporterException;
use Aedart\Contracts\Translation\Exports\Exceptions\ProfileNotFoundException;
use Aedart\Contracts\Translation\Exports\Exporter;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Translation\TranslationTestCase;
use Aedart\Translation\Exports\Drivers\LangJsJsonExporter;
use Aedart\Utils\Json;
use Codeception\Attribute\Group;
use JsonException;
use PHPUnit\Framework\Attributes\Test;

/**
 * LangJsJsonExporterTest
 *
 * @group translations
 * @group translations-exporter
 * @group translations-exporter-drivers
 * @group translations-exporter-drivers-lang-js-json
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Translation\Exports\Drivers
 */
#[Group(
    'translations',
    'translations-exporter',
    'translations-exporter-drivers',
    'translations-exporter-drivers-lang-js-json',
)]
class LangJsJsonExporterTest extends TranslationTestCase
{
    /*****************************************************************
     * helpers
     ****************************************************************/

    /**
     * Returns exporter instance
     *
     * @param array $options [optional]
     *
     * @return Exporter|LangJsJsonExporter
     *
     * @throws ProfileNotFoundException
     */
    public function exporter(array $options = []): Exporter|LangJsJsonExporter
    {
        return $this->makeExporter('lang_js_json', $options);
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
    #[Test]
    public function canObtainExporter(): void
    {
        $exporter = $this->exporter();

        $this->assertInstanceOf(LangJsJsonExporter::class, $exporter);
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws ProfileNotFoundException
     * @throws ExporterException
     */
    #[Test]
    public function canExport(): void
    {
        $translations = $this->exporter()->export();

        ConsoleDebugger::output($translations);

        // -----------------------------------------------------------------------------//

        $this->assertJson($translations);
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws ExporterException
     * @throws ProfileNotFoundException
     * @throws JsonException
     */
    #[Test]
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

        $this->assertJson($translations);

        $decoded = Json::decode($translations, true);

        $this->assertArrayHasKey('en.__JSON__', $decoded);
        $this->assertArrayHasKey('en.auth', $decoded);
        $this->assertArrayHasKey('en.translation-test::users', $decoded);
    }
}
