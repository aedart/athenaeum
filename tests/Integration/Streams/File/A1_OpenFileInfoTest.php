<?php

namespace Aedart\Tests\Integration\Streams\File;

use Aedart\Contracts\Streams\Exceptions\StreamException;
use Aedart\Streams\FileStream;
use Aedart\Tests\TestCases\Streams\StreamTestCase;
use Illuminate\Http\UploadedFile;
use SplFileInfo;

/**
 * A1_OpenFileInfoTest
 *
 * @group streams
 * @group streams-file-a1
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Streams\File
 */
class A1_OpenFileInfoTest extends StreamTestCase
{
    /**
     * @test
     *
     * @return void
     *
     * @throws StreamException
     */
    public function canOpenFileInfo(): void
    {
        $file = $this->filePath('text.txt');
        $fileInfo = new SplFileInfo($file);

        $stream = FileStream::openFileInfo($fileInfo, 'r');

        $this->assertTrue($stream->isOpen());
        $this->assertFalse($stream->isDetached());
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws StreamException
     */
    public function canOpenLaravelUploadedFile(): void
    {
        $file = 'text.txt';
        $uploadedFile = UploadedFile::fake()
            ->createWithContent($file, $this->getFaker()->sentence(5));

        $stream = FileStream::openFileInfo($uploadedFile, 'r');

        $this->assertTrue($stream->isOpen());
        $this->assertFalse($stream->isDetached());

        // Ensure that the original name is available in the meta
        $this->assertSame($stream->meta()->get('filename'), $file);
    }
}
