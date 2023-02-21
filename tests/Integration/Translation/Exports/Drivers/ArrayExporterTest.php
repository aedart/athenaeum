<?php

namespace Aedart\Tests\Integration\Translation\Exports\Drivers;

use Aedart\Contracts\Translation\Exports\Exceptions\ProfileNotFoundException;
use Aedart\Contracts\Translation\Exports\Exporter;
use Aedart\Tests\TestCases\Translation\TranslationTestCase;
use Aedart\Translation\Exports\Drivers\ArrayExporter;

/**
 * ArrayExporterTest
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
        return $this->makeExporter('array', $options);
    }

    /*****************************************************************
     * Actual tests
     ****************************************************************/
}