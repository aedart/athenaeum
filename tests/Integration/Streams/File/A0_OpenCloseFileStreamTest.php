<?php

namespace Aedart\Tests\Integration\Streams\File;

use Aedart\Streams\Exceptions\CannotOpenStream;
use Aedart\Streams\FileStream;
use Aedart\Tests\TestCases\Streams\StreamTestCase;

/**
 * A0_OpenCloseFileStreamTest
 *
 * @group streams
 * @group streams-file-a0
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Streams\File
 */
class A0_OpenCloseFileStreamTest extends StreamTestCase
{
    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    public function canOpenMemoryStream()
    {
        $stream = FileStream::openMemory();

        $this->assertTrue($stream->isOpen());
        $this->assertFalse($stream->isDetached());
    }

    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    public function canOpenTempStream()
    {
        $stream = FileStream::openTemporary();

        $this->assertTrue($stream->isOpen());
        $this->assertFalse($stream->isDetached());
    }

    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    public function canOpenFileStream()
    {
        $path = $this->filePath('text.txt');
        $stream = FileStream::open($path, 'r');

        $this->assertTrue($stream->isOpen());
        $this->assertFalse($stream->isDetached());
    }

    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    public function failsWhenFileCannotBeOpened()
    {
        $this->expectException(CannotOpenStream::class);

        $path = $this->filePath('unknown-file.txt');
        FileStream::open($path, 'r');
    }
}
