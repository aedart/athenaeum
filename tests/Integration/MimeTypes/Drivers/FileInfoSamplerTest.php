<?php

namespace Aedart\Tests\Integration\MimeTypes\Drivers;

use Aedart\Contracts\MimeTypes\Exceptions\MimeTypeDetectionException;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\MimeTypes\MimeTypesTestCase;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * FileInfoSamplerTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\MimeTypes\Drivers
 */
#[Group(
    'mime-types',
    'mime-types-samplers',
    'file-info-sampler'
)]
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
     * @return void
     *
     * @throws MimeTypeDetectionException
     */
    #[Test]
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
     * @param  array  $expectation
     *
     * @return void
     *
     * @throws MimeTypeDetectionException
     */
    #[DataProvider('testFiles')]
    #[Test]
    public function canDetectFromString(array $expectation)
    {
        [$ext, $type, $encoding] = $expectation;

        $mimeType = $this->mimeTypeUsingStringContent($ext, $this->driverProfile());

        ConsoleDebugger::output($mimeType);

        $this->assertTrue($mimeType->isValid());
        $this->assertSame($type, $mimeType->type(), 'Incorrect typo');
        $this->assertSame($encoding, $mimeType->encoding(), 'Incorrect encoding');
        $this->assertNotEmpty($mimeType->mime(), 'Empty mime');
        $this->assertIsArray($mimeType->knownFileExtensions()); // A bit useless...
    }

    /**
     * @param  array  $expectation
     *
     * @return void
     *
     * @throws MimeTypeDetectionException
     */
    #[DataProvider('testFiles')]
    #[Test]
    public function canDetectFromStream(array $expectation)
    {
        [$ext, $type, $encoding] = $expectation;

        $mimeType = $this->mimeTypeUsingStream($ext, $this->driverProfile());

        ConsoleDebugger::output($mimeType);

        $this->assertTrue($mimeType->isValid());
        $this->assertSame($type, $mimeType->type(), 'Incorrect typo');
        $this->assertSame($encoding, $mimeType->encoding(), 'Incorrect encoding');
        $this->assertNotEmpty($mimeType->mime(), 'Empty mime');
        $this->assertIsArray($mimeType->knownFileExtensions()); // A bit useless...
    }
}
