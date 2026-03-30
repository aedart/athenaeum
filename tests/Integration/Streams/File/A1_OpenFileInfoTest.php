<?php

namespace Aedart\Tests\Integration\Streams\File;

use Aedart\Contracts\Streams\Exceptions\StreamException;
use Aedart\Streams\FileStream;
use Aedart\Tests\TestCases\Streams\StreamTestCase;
use Codeception\Attribute\Group;
use Illuminate\Http\UploadedFile;
use PHPUnit\Framework\Attributes\Test;
use SplFileInfo;

/**
 * A1_OpenFileInfoTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Streams\File
 */
#[Group(
    'streams',
    'stream-file',
    'stream-file-a1',
)]
class A1_OpenFileInfoTest extends StreamTestCase
{
    /**
     * @return void
     *
     * @throws StreamException
     */
    #[Test]
    public function canOpenFileInfo(): void
    {
        $file = $this->filePath('text.txt');
        $fileInfo = new SplFileInfo($file);

        $stream = FileStream::openFileInfo($fileInfo, 'r');

        $this->assertTrue($stream->isOpen());
        $this->assertFalse($stream->isDetached());
    }

    /**
     * @return void
     *
     * @throws StreamException
     */
    #[Test]
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
