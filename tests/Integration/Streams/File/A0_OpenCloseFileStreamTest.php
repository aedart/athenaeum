<?php

namespace Aedart\Tests\Integration\Streams\File;

use Aedart\Streams\Exceptions\CannotOpenStream;
use Aedart\Streams\FileStream;
use Aedart\Tests\TestCases\Streams\StreamTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * A0_OpenCloseFileStreamTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Streams\File
 */
#[Group(
    'streams',
    'stream-file',
    'stream-file-a0',
)]
class A0_OpenCloseFileStreamTest extends StreamTestCase
{
    /**
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function canOpenMemoryStream()
    {
        $stream = FileStream::openMemory();

        $this->assertTrue($stream->isOpen());
        $this->assertFalse($stream->isDetached());
    }

    /**
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function canOpenTempStream()
    {
        $stream = FileStream::openTemporary();

        $this->assertTrue($stream->isOpen());
        $this->assertFalse($stream->isDetached());
    }

    /**
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function canOpenFileStream()
    {
        $path = $this->filePath('text.txt');
        $stream = FileStream::open($path, 'r');

        $this->assertTrue($stream->isOpen());
        $this->assertFalse($stream->isDetached());
    }

    /**
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function failsWhenFileCannotBeOpened()
    {
        $this->expectException(CannotOpenStream::class);

        $path = $this->filePath('unknown-file.txt');
        FileStream::open($path, 'r');
    }
}
