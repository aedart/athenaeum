<?php

namespace Aedart\Tests\Integration\Translation\Exports\Drivers;

use Aedart\Contracts\Translation\Exports\Exceptions\ExporterException;
use Aedart\Contracts\Translation\Exports\Exceptions\ProfileNotFoundException;
use Aedart\Contracts\Translation\Exports\Exporter;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Translation\TranslationTestCase;
use Aedart\Translation\Exports\Drivers\BaseExporter;
use Aedart\Translation\Exports\Exceptions\InvalidLocales;
use Aedart\Translation\Exports\Exceptions\InvalidPaths;
use Codeception\Attribute\Group;
use Illuminate\Contracts\Translation\Loader;
use Mockery as m;
use PHPUnit\Framework\Attributes\Test;

/**
 * BaseExporterTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Translation\Exports\Drivers
 */
#[Group(
    'translations',
    'translations-exporter',
    'translations-exporter-drivers',
    'translations-exporter-drivers-base',
)]
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
     * @return Exporter|BaseExporter
     *
     * @throws ProfileNotFoundException
     */
    public function exporter(array $options = []): Exporter|BaseExporter
    {
        return $this->makeExporter('null', $options);
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
    public function hasTranslationsLoader(): void
    {
        $loader = $this->exporter()->getTranslationLoader();

        $this->assertInstanceOf(Loader::class, $loader);
    }

    /**
     * @return void
     *
     * @throws ProfileNotFoundException
     */
    #[Test]
    public function canDetectLocals(): void
    {
        $locales = $this->exporter()->detectLocals();

        ConsoleDebugger::output($locales);

        $this->assertGreaterThanOrEqual(1, $locales);
        $this->assertTrue(in_array('en', $locales), 'en locale not detected');
    }

    /**
     * @return void
     *
     * @throws ProfileNotFoundException
     */
    #[Test]
    public function canDetectGroups(): void
    {
        $groups = $this->exporter()->detectGroups();

        ConsoleDebugger::output($groups);

        $this->assertGreaterThanOrEqual(4, $groups);
        $this->assertTrue(in_array('*::auth', $groups), '*::auth not detected');
        $this->assertTrue(in_array('athenaeum-http-api::api-resources', $groups), 'athenaeum-http-api::api-resources not detected');
    }

    /**
     * @return void
     *
     * @throws ProfileNotFoundException
     */
    #[Test]
    public function canObtainNamespacePaths(): void
    {
        $paths = $this->exporter()->getNamespacesWithPaths();

        ConsoleDebugger::output($paths);

        $this->assertNotEmpty($paths);
    }

    /**
     * @return void
     *
     * @throws ProfileNotFoundException
     */
    #[Test]
    public function canObtainJsonPaths(): void
    {
        $paths = $this->exporter()->getJsonPaths();

        ConsoleDebugger::output($paths);

        $this->assertNotEmpty($paths);
    }

    /**
     * @return void
     *
     * @throws ProfileNotFoundException
     */
    #[Test]
    public function mergesNamespaceAndJsonPathsWithUserProvidedPaths(): void
    {
        $exporter = $this->exporter();
        $paths = $exporter->getPaths();

        ConsoleDebugger::output($paths);

        // ------------------------------------------------------------- //

        $this->assertGreaterThanOrEqual(4, $paths);

        $namespacePaths = $exporter->getNamespacesWithPaths();
        foreach ($namespacePaths as $np) {
            $this->assertTrue(in_array($np, $paths), sprintf('Namespace path %s not part of paths', $np));
        }

        $jsonPaths = $exporter->getJsonPaths();
        foreach ($jsonPaths as $jp) {
            $this->assertTrue(in_array($jp, $paths), sprintf('Json path %s not part of paths', $jp));
        }
    }

    /**
     * @return void
     *
     * @throws ProfileNotFoundException
     * @throws ExporterException
     */
    #[Test]
    public function failsExportWhenNoPathsAvailable(): void
    {
        $this->expectException(InvalidPaths::class);

        $loader = m::mock(Loader::class)
            ->allows([
                'namespaces' => [],
                'jsonPaths' => [],
            ]);

        $exporter = $this->exporter([
            'paths' => []
        ])->setTranslationLoader($loader);

        $exporter->export();
    }

    /**
     * @return void
     *
     * @throws ExporterException
     * @throws ProfileNotFoundException
     */
    #[Test]
    public function failsExportWhenInvalidLocalesProvided(): void
    {
        $this->expectException(InvalidLocales::class);

        $this->exporter()->export([]);
    }

    /**
     * @return void
     *
     * @throws ExporterException
     * @throws ProfileNotFoundException
     */
    #[Test]
    public function canExport(): void
    {
        // NOTE: Test uses null driver, so no exports are to be expected.
        // WE are only interested to see that the "performExport" method
        // is invoked as intended.

        $result = $this->exporter()->export();

        $this->assertNull($result);
    }
}
