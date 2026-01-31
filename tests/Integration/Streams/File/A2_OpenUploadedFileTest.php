<?php

namespace Aedart\Tests\Integration\Streams\File;

use Aedart\Contracts\Streams\Exceptions\StreamException;
use Aedart\Streams\FileStream;
use Aedart\Tests\TestCases\Streams\StreamTestCase;
use Codeception\Attribute\Group;
use GuzzleHttp\Psr7\Stream;
use GuzzleHttp\Psr7\UploadedFile;
use PHPUnit\Framework\Attributes\Test;
use Psr\Http\Message\UploadedFileInterface;

/**
 * A2_OpenUploadedFileTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Streams\File
 */
#[Group(
    'streams',
    'stream-file',
    'stream-file-a2',
)]
class A2_OpenUploadedFileTest extends StreamTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Makes a new PSR-7 Uploaded File instance
     *
     * @param string $file
     *
     * @return UploadedFileInterface
     */
    public function makeUploadedFile(string $file): UploadedFileInterface
    {
        // Make a normal Psr stream, because Guzzle's uploaded file instance
        // uses a custom "Lazy Open Stream", which appears not to be correctly
        // detached?!
        $psrStream = new Stream(
            fopen($this->filePath($file), 'r')
        );

        return new UploadedFile(
            streamOrFile: $psrStream,
            size: null,
            errorStatus: UPLOAD_ERR_OK,
            clientFilename: $file
        );
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @return void
     *
     * @throws StreamException
     */
    #[Test]
    public function canOpenUploadedFile(): void
    {
        $file = 'text.txt';
        $uploadedFile = $this->makeUploadedFile($file);

        $stream = FileStream::openUploadedFile($uploadedFile);

        $this->assertTrue($stream->isOpen());
        $this->assertFalse($stream->isDetached());

        // Ensure that "client" filename is set in meta
        $this->assertSame($stream->meta()->get('filename'), $file);

        // Original stream should be detached...
        $this->assertNull($uploadedFile->getStream()->detach(), 'Original stream SHOULD be detached');
    }

    /**
     * @return void
     *
     * @throws StreamException
     */
    #[Test]
    public function canOpenUploadFileAsCopy(): void
    {
        $uploadedFile = $this->makeUploadedFile('text.txt');

        $stream = FileStream::openUploadedFile(
            file: $uploadedFile,
            asCopy: true
        );

        $this->assertTrue($stream->isOpen());
        $this->assertFalse($stream->isDetached());

        // Original stream should NOT detached...
        $this->assertNotNull($uploadedFile->getStream()->detach(), 'Original stream SHOULD NOT be detached');
    }
}
