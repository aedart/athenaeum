<?php

namespace Aedart\Tests\Integration\Streams\File;

use Aedart\Contracts\Streams\Exceptions\StreamException;
use Aedart\Streams\FileStream;
use Aedart\Tests\TestCases\Streams\StreamTestCase;
use Aedart\Utils\Str;
use GuzzleHttp\Psr7\Stream as PsrStream;

/**
 * B0_CopyTest
 *
 * @group streams
 * @group streams-file-b0
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Streams\File
 */
class B0_CopyTest extends StreamTestCase
{
    /**
     * @test
     *
     * @return void
     *
     * @throws StreamException
     */
    public function canCopyStream(): void
    {
        $data = $this->getFaker()->realText(25);
        $stream = FileStream::openMemory()
            ->put($data)
            ->positionToStart();

        $copy = $stream->copy();

        $this->assertNotSame($stream, $copy, 'Same instance returned!');
        $this->assertSame($stream->getContents(), $copy->getContents());
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws StreamException
     */
    public function canCopyToTargetStream(): void
    {
        $data = $this->getFaker()->realText(25);

        $target = FileStream::openMemory();
        $stream = FileStream::openMemory()
            ->put($data)
            ->positionToStart();

        $copy = $stream->copyTo($target);

        $this->assertNotSame($stream, $copy, 'Same instance returned!');
        $this->assertSame($target, $copy, 'Copy and target should be the same instance');
        $this->assertSame($stream->getContents(), $target->getContents());
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws StreamException
     */
    public function canCopyFromResource(): void
    {
        $data = Str::random(50);
        $source = FileStream::openMemory()
            ->put($data)
            ->positionToStart();

        $target = FileStream::openMemory()
            ->copyFrom($source->resource());

        // ------------------------------------------------------------------ //

        $source->rewind();
        $target->rewind();

        $this->assertSame($source->getContents(), $target->getContents());
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws StreamException
     */
    public function canCopyFromStream(): void
    {
        $data = Str::random(50);
        $source = FileStream::openMemory()
            ->put($data)
            ->positionToStart();

        $target = FileStream::openMemory()
            ->copyFrom($source);

        // ------------------------------------------------------------------ //

        $source->rewind();
        $target->rewind();

        $this->assertSame($source->getContents(), $target->getContents());
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws StreamException
     */
    public function canCopyFromPsrStream(): void
    {
        $data = Str::random(50);

        $source = new PsrStream(
            fopen('php://memory', 'r+b')
        );
        $source->write($data);
        $source->rewind();

        $target = FileStream::openMemory()
            ->copyFrom($source);

        // ------------------------------------------------------------------ //

        $source->rewind();
        $target->rewind();

        $this->assertSame($source->getContents(), $target->getContents());
        $this->assertIsResource($source->detach(), 'PSR stream was detached by copy operation, but SHOULD NOT be');
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws StreamException
     */
    public function canCopyAtOffsetFromPsrStream(): void
    {
        $data = Str::random(50);

        $source = new PsrStream(
            fopen('php://memory', 'r+b')
        );
        $source->write($data);
        $source->rewind();

        $length = null;
        $offset = 3;
        $target = FileStream::openMemory()
            ->copyFrom($source, $length, $offset);

        // ------------------------------------------------------------------ //

        $source->rewind();
        $target->rewind();

        $source->seek($offset);
        $this->assertSame($source->getContents(), $target->getContents());
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws StreamException
     */
    public function canCopyLengthFromPsrStream(): void
    {
        $data = Str::random(50);

        $source = new PsrStream(
            fopen('php://memory', 'r+b')
        );
        $source->write($data);
        $source->rewind();

        $length = 19;
        $offset = 0;
        $target = FileStream::openMemory()
            ->copyFrom($source, $length, $offset);

        // ------------------------------------------------------------------ //

        $source->rewind();
        $target->rewind();

        $source->seek($offset);
        $this->assertSame($source->read($length), $target->getContents());
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws StreamException
     */
    public function canCopyFromPsrStreamWithBuffer(): void
    {
        $data = Str::random(50);

        $source = new PsrStream(
            fopen('php://memory', 'r+b')
        );
        $source->write($data);
        $source->rewind();

        $length = null;
        $offset = 0;
        $buffer = 6;
        $target = FileStream::openMemory()
            ->copyFrom($source, $length, $offset, $buffer);

        // ------------------------------------------------------------------ //

        $source->rewind();
        $target->rewind();

        $source->seek($offset);
        $this->assertSame($source->getContents(), $target->getContents());
    }
}
