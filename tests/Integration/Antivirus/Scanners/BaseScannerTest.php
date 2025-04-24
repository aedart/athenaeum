<?php

namespace Aedart\Tests\Integration\Antivirus\Scanners;

use Aedart\Antivirus\Exceptions\UnableToOpenFileStream;
use Aedart\Contracts\Antivirus\Events\FileWasScanned;
use Aedart\Contracts\Antivirus\Exceptions\AntivirusException;
use Aedart\Contracts\Antivirus\Exceptions\ProfileNotFoundException;
use Aedart\Contracts\Antivirus\Results\ScanResult;
use Aedart\Contracts\Antivirus\Scanner;
use Aedart\Contracts\Streams\Exceptions\StreamException;
use Aedart\Streams\FileStream;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Antivirus\AntivirusTestCase;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Group;
use GuzzleHttp\Psr7\UploadedFile as PsrUploadedFile;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Event;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Psr\Http\Message\StreamInterface as PsrStream;
use RuntimeException;
use SplFileInfo;

/**
 * BaseScannerTest
 *
 * @group antivirus
 * @group antivirus-scanners
 * @group antivirus-scanners-base
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Antivirus\Scanners
 */
#[Group(
    'antivirus',
    'antivirus-scanners',
    'antivirus-scanners-base',
)]
class BaseScannerTest extends AntivirusTestCase
{
    /*****************************************************************
     * Data Providers
     ****************************************************************/

    /**
     * Provides "files" in different data types
     *
     * @return array[]
     *
     * @throws StreamException
     */
    public function fileFormatsProvider(): array
    {
        $path = $this->cleanFile();

        return [
            'String path' => [ $path ],
            'SplFileInfo' => [ new SplFileInfo($path) ],
            'Laravel uploaded file' => [ UploadedFile::fake()->create('other.txt', 'Lorum lipsum', 'text/plain') ],
            'PSR-7 uploaded file' => [ new PsrUploadedFile($path, 12, UPLOAD_ERR_OK, 'myFile.txt') ],
            'File stream' => [ FileStream::open($path, 'r') ],
            'PSR-7 file stream' => [ (new PsrUploadedFile($path, 12, UPLOAD_ERR_OK))->getStream() ],
        ];
    }

    /**
     * Provides "invalid" files in different data types
     *
     * @return array
     */
    public function invalidFilePathsProvider(): array
    {
        $invalidPath = '/tmp/unknown_file' . $this->getFaker()->randomNumber(5, true) . '.txt';

        $fileStreamMock = Mockery::mock(FileStream::class)
            ->shouldReceive('rewind')
            ->andThrow(RuntimeException::class, 'Test failure');

        $psrFileStreamMock = Mockery::mock(PsrStream::class)
            ->shouldReceive('isReadable')
            ->andReturn(false);

        return [
            'Invalid string path' => [ $invalidPath ],
            'Invalid SplFileInfo' => [ new SplFileInfo($invalidPath) ],
            'Laravel uploaded file' => [ new UploadedFile(path: $invalidPath, originalName: 'unknown', error: UPLOAD_ERR_NO_FILE) ],
            'PSR-7 uploaded file' => [ new PsrUploadedFile($invalidPath, 12, UPLOAD_ERR_OK) ],
            'File stream' => [ $fileStreamMock ],
            'PSR-7 file stream' => [ $psrFileStreamMock ],
        ];
    }

    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Returns the scanner to be tested...
     *
     * @param array $options [optional]
     *
     * @return Scanner
     *
     * @throws ProfileNotFoundException
     */
    public function scanner(array $options = []): Scanner
    {
        return $this->makeScanner('null', $options);
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     * @dataProvider fileFormatsProvider
     *
     * @param mixed $file
     *
     * @return void
     *
     * @throws ProfileNotFoundException
     * @throws AntivirusException
     */
    #[DataProvider('fileFormatsProvider')]
    #[Test]
    public function canScan(mixed $file): void
    {
        // This test is concerned about the base scanners ability to "wrap"
        // the supported file types and passing it on...

        $result = $this->scanner()->scan($file);

        ConsoleDebugger::output($result->toArray());

        $this->assertInstanceOf(ScanResult::class, $result);
    }

    /**
     * @test
     * @dataProvider fileFormatsProvider
     *
     * @param mixed $file
     *
     * @return void
     *
     * @throws AntivirusException
     * @throws ProfileNotFoundException
     */
    #[DataProvider('fileFormatsProvider')]
    #[Test]
    public function canDetermineIfFileIsClean(mixed $file): void
    {
        // Here we do NOT care about actual clean / infected status, but
        // more that the "isClean" returns as expected.

        $expected = $this->getFaker()->boolean();

        // The null scanner allows setting a "should pass" which
        // changes the scan status' result.
        $result = $this->scanner([
            'should_pass' => $expected
        ])->isClean($file);

        $this->assertSame($expected, $result);
    }

    /**
     * @test
     * @dataProvider invalidFilePathsProvider
     *
     * @param mixed $file
     *
     * @return void
     *
     * @throws AntivirusException
     * @throws ProfileNotFoundException
     */
    #[DataProvider('invalidFilePathsProvider')]
    #[Test]
    public function failsWhenUnableToOpenFileStream(mixed $file): void
    {
        // The focus of this test is to ensure that a correct exception
        // type is thrown when invalid path or streams are somehow provided...
        $this->expectException(UnableToOpenFileStream::class);

        $this->scanner()->scan($file);
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws AntivirusException
     * @throws ProfileNotFoundException
     */
    #[Test]
    public function dispatchesFileWasScannedEvent(): void
    {
        Event::fake();

        $this->scanner()->scan(
            $this->cleanFile()
        );

        Event::assertDispatched(FileWasScanned::class);
    }
}
