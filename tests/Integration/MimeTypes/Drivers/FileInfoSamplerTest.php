<?php

namespace Aedart\Tests\Integration\MimeTypes\Drivers;

use Aedart\Contracts\MimeTypes\Exceptions\MimeTypeDetectionException;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\MimeTypes\MimeTypesTestCase;

/**
 * FileInfoSamplerTest
 *
 * @group mime-types
 * @group mime-types-samplers
 * @group file-info-sampler
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\MimeTypes\Drivers
 */
class FileInfoSamplerTest extends MimeTypesTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Returns sampler (driver) profile name
     *
     * @return string
     */
    public function driverProfile(): string
    {
        return 'file-info';
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     *
     * @return void
     *
     * @throws MimeTypeDetectionException
     */
    public function failsWhenInvalidMagicDatabasePathProvided()
    {
        $this->expectException(MimeTypeDetectionException::class);

        $mimeType = $this->mimeTypeUsingStringContent('txt', $this->driverProfile(), [
            'magic_database' => '/path/to/some/unknown/magic_db.mgc'
        ]);

        // This should trigger exception...
        $mimeType->type();
    }

    /**
     * @test
     * @dataProvider testFiles
     *
     * @param  array  $expectation
     *
     * @return void
     *
     * @throws MimeTypeDetectionException
     */
    public function canDetectFromString(array $expectation)
    {
        list($ext, $type, $encoding) = $expectation;

        $mimeType = $this->mimeTypeUsingStringContent($ext, $this->driverProfile());

        ConsoleDebugger::output($mimeType);

        $this->assertSame($type, $mimeType->type(), 'Incorrect typo');
        $this->assertSame($encoding, $mimeType->encoding(), 'Incorrect encoding');
        $this->assertNotEmpty($mimeType->mime(), 'Empty mime');
        $this->assertIsArray($mimeType->knownFileExtensions()); // A bit useless...
    }

    /**
     * @test
     * @dataProvider testFiles
     *
     * @param  array  $expectation
     *
     * @return void
     *
     * @throws MimeTypeDetectionException
     */
    public function canDetectFromStream(array $expectation)
    {
        list($ext, $type, $encoding) = $expectation;

        $mimeType = $this->mimeTypeUsingStream($ext, $this->driverProfile());

        ConsoleDebugger::output($mimeType);

        $this->assertSame($type, $mimeType->type(), 'Incorrect typo');
        $this->assertSame($encoding, $mimeType->encoding(), 'Incorrect encoding');
        $this->assertNotEmpty($mimeType->mime(), 'Empty mime');
        $this->assertIsArray($mimeType->knownFileExtensions()); // A bit useless...
    }
}
