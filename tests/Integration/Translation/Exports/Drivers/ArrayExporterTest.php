<?php

namespace Aedart\Tests\Integration\Translation\Exports\Drivers;

use Aedart\Contracts\Translation\Exports\Exceptions\ExporterException;
use Aedart\Contracts\Translation\Exports\Exceptions\ProfileNotFoundException;
use Aedart\Contracts\Translation\Exports\Exporter;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Translation\TranslationTestCase;
use Aedart\Translation\Exports\Drivers\ArrayExporter;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * ArrayExporterTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Translation\Exports\Drivers
 */
#[Group(
    'translations',
    'translations-exporter',
    'translations-exporter-drivers',
    'translations-exporter-drivers-array',
)]
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
     * @return void
     *
     * @throws ProfileNotFoundException
     */
    #[Test]
    public function canObtainExporter(): void
    {
        $exporter = $this->exporter();

        $this->assertInstanceOf(ArrayExporter::class, $exporter);
    }

    /**
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

        $this->assertNotEmpty($translations, 'No translations exported');

        $this->assertArrayHasKey('en', $translations);
        $this->assertArrayHasKey('__JSON__', $translations['en'], 'en has no json group');
        $this->assertNotEmpty($translations['en']['__JSON__'], 'en __JSON__ is empty');

        $this->assertArrayHasKey('auth', $translations['en'], 'en has no auth group');
        $this->assertNotEmpty($translations['en']['auth'], 'en auth is empty');

        $this->assertArrayHasKey('pagination', $translations['en'], 'en has no pagination group');
        $this->assertNotEmpty($translations['en']['pagination'], 'en pagination is empty');

        $this->assertArrayHasKey('passwords', $translations['en'], 'en has no passwords group');
        $this->assertNotEmpty($translations['en']['passwords'], 'en passwords is empty');

        $this->assertArrayHasKey('validation', $translations['en'], 'en has no validation group');
        $this->assertNotEmpty($translations['en']['validation'], 'en validation is empty');

        $this->assertArrayHasKey('athenaeum-http-api::api-resources', $translations['en'], 'en has no athenaeum-http-api::api-resources group');
        $this->assertNotEmpty($translations['en']['athenaeum-http-api::api-resources'], 'en athenaeum-http-api::api-resources is empty');

        $this->assertArrayHasKey('translation-test::users', $translations['en'], 'en has no translation-test::users group');
        $this->assertNotEmpty($translations['en']['translation-test::users'], 'en translation-test::users is empty');

        $this->assertArrayHasKey('da', $translations);
        $this->assertArrayHasKey('__JSON__', $translations['da'], 'da has no json group');
        $this->assertNotEmpty($translations['da']['__JSON__'], 'da __JSON__ is empty');

        $this->assertArrayHasKey('translation-test::users', $translations['da'], 'da has no translation-test::users group');
        $this->assertNotEmpty($translations['da']['translation-test::users'], 'da translation-test::users is empty');

        $this->assertArrayHasKey('en-uk', $translations);
        $this->assertArrayHasKey('__JSON__', $translations['en-uk'], 'en-uk has no json group');
        $this->assertNotEmpty($translations['en-uk']['__JSON__'], 'en-uk __JSON__ is empty');
    }

    /**
     * @return void
     *
     * @throws ExporterException
     * @throws ProfileNotFoundException
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

        $this->assertNotEmpty($translations, 'No translations exported');

        $this->assertArrayHasKey('en', $translations);
        $this->assertArrayHasKey('__JSON__', $translations['en'], 'en has no json group');
        $this->assertNotEmpty($translations['en']['__JSON__'], 'en __JSON__ is empty');

        $this->assertArrayHasKey('auth', $translations['en'], 'en has no auth group');
        $this->assertNotEmpty($translations['en']['auth'], 'en auth is empty');

        $this->assertArrayHasKey('translation-test::users', $translations['en'], 'en has no translation-test::users group');
        $this->assertNotEmpty($translations['en']['translation-test::users'], 'en translation-test::users is empty');

        $this->assertArrayNotHasKey('da', $translations);
        $this->assertArrayNotHasKey('en-uk', $translations);
    }

    /**
     * @return void
     *
     * @throws ExporterException
     * @throws ProfileNotFoundException
     */
    #[Test]
    public function canExportTranslationsFromNamespacesAndJsonPaths(): void
    {
        // NOTE: deferrable namespace is registered in test configuration

        $translations = $this->exporter()->export(
            locales: ['en-uk', 'da'],
            groups: 'deferrable::messages'
        );

        ConsoleDebugger::output($translations);

        // -----------------------------------------------------------------------------//

        $this->assertNotEmpty($translations, 'No translations exported');

        $this->assertArrayHasKey('en-uk', $translations);
        $this->assertArrayHasKey('deferrable::messages', $translations['en-uk'], 'en-uk has no json group');
        $this->assertNotEmpty($translations['en-uk']['deferrable::messages'], 'en-uk deferrable::messages is empty');

        $this->assertArrayHasKey('da', $translations);
        $this->assertArrayHasKey('__JSON__', $translations['da'], 'da has no json group');
        $this->assertNotEmpty($translations['da']['__JSON__'], 'da __JSON__ is empty');
        $this->assertArrayHasKey('measurement', $translations['da']['__JSON__'], 'no "measurement" item found in da __JSON__');
    }
}
