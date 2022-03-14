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
     * Data Providers
     ****************************************************************/

    /**
     * Provides test files
     *
     * @return array
     */
    public function testFiles(): array
    {
        // Lookup mime types / content types:
        // @see https://svn.apache.org/repos/asf/httpd/httpd/trunk/docs/conf/mime.types
        // @see https://fileinfo.com/

        return [
            '7z' => $this->makeTestFileExpectation(
                '7z',
                'application/x-7z-compressed',
                'binary',
                extensions: [ '7z', 'cb7' ]
            ),
            'jpg' => $this->makeTestFileExpectation(
                'jpg',
                'image/jpeg',
                'binary',
                extensions: [ 'jpeg', 'jpg', 'jpe', 'jfif' ]
            ),
            'tar.xz' => $this->makeTestFileExpectation(
                'tar.xz',
                'application/x-xz',
                'binary',
                extensions: [  ]
            ),
            'txt' => $this->makeTestFileExpectation(
                'txt',
                'text/plain',
                'us-ascii',
                extensions: [  ] // Okay...? finfo does not offer any extensions for *.txt files!?!
            ),
            'zip' => $this->makeTestFileExpectation(
                'zip',
                'application/zip',
                'binary',
                extensions: [  ] // Hmmm...? finfo does not know zip either?
            ),
        ];
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
        list($ext, $type, $encoding, $extensions) = $expectation;

        $mimeType = $this->mimeTypeUsingStringContent($ext, $this->driverProfile());

        ConsoleDebugger::output($mimeType);

        $this->assertSame($type, $mimeType->type(), 'Incorrect typo');
        $this->assertSame($encoding, $mimeType->encoding(), 'Incorrect encoding');
        $this->assertSame($extensions, $mimeType->fileExtensions(), 'Incorrect file extensions');

        if (!empty($extensions)) {
            $this->assertNotNull($mimeType->fileExtension(), 'File extension was not resolved');
        } else {
            $this->assertNull($mimeType->fileExtension(), 'Hmmm... extension was detected when none was expected');
        }
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
        list($ext, $type, $encoding, $extensions) = $expectation;

        $mimeType = $this->mimeTypeUsingStream($ext, $this->driverProfile());

        ConsoleDebugger::output($mimeType);

        $this->assertSame($type, $mimeType->type(), 'Incorrect typo');
        $this->assertSame($encoding, $mimeType->encoding(), 'Incorrect encoding');
        $this->assertSame($extensions, $mimeType->fileExtensions(), 'Incorrect file extensions');

        if (!empty($extensions)) {
            $this->assertNotNull($mimeType->fileExtension(), 'File extension was not resolved');
        } else {
            $this->assertNull($mimeType->fileExtension(), 'Hmmm... extension was detected when none was expected');
        }
    }
}
