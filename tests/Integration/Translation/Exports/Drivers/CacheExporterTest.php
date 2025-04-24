<?php

namespace Aedart\Tests\Integration\Translation\Exports\Drivers;

use Aedart\Contracts\Translation\Exports\Exceptions\ExporterException;
use Aedart\Contracts\Translation\Exports\Exceptions\ProfileNotFoundException;
use Aedart\Contracts\Translation\Exports\Exporter;
use Aedart\Support\Helpers\Cache\CacheFactoryTrait;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Translation\TranslationTestCase;
use Aedart\Translation\Exports\Drivers\CacheExporter;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;
use Psr\SimpleCache\InvalidArgumentException;

/**
 * CacheExporterTest
 *
 * @group translations
 * @group translations-exporter
 * @group translations-exporter-drivers
 * @group translations-exporter-drivers-cache
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Translation\Exports\Drivers
 */
#[Group(
    'translations',
    'translations-exporter',
    'translations-exporter-drivers',
    'translations-exporter-drivers-cache',
)]
class CacheExporterTest extends TranslationTestCase
{
    use CacheFactoryTrait;

    /*****************************************************************
     * helpers
     ****************************************************************/

    /**
     * Returns exporter instance
     *
     * @param array $options [optional]
     *
     * @return Exporter|CacheExporter
     *
     * @throws ProfileNotFoundException
     */
    public function exporter(array $options = []): Exporter|CacheExporter
    {
        return $this->makeExporter('cache', $options);
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

        $this->assertInstanceOf(CacheExporter::class, $exporter);
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws ProfileNotFoundException
     * @throws ExporterException
     * @throws InvalidArgumentException
     */
    #[Test]
    public function cachesExports(): void
    {
        $exporter = $this->exporter();
        $cache = $exporter->cache();
        $key = $exporter->key();

        // -----------------------------------------------------------------------------//

        $translations = $exporter->export(
            locales: 'en',
            groups: [
                'auth',
                'translation-test::users'
            ]
        );

        ConsoleDebugger::output($translations);

        // -----------------------------------------------------------------------------//

        $this->assertTrue($cache->has($key), 'Cache does not have key');

        $result = $cache->get($key);
        $this->assertSame($translations, $result, 'Incorrect cached translations');

        // -----------------------------------------------------------------------------//
        // Cleanup
        $cache->forget($key);
    }
}
