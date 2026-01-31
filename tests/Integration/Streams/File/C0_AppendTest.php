<?php

namespace Aedart\Tests\Integration\Streams\File;

use Aedart\Streams\Exceptions\CannotCopyToTargetStream;
use Aedart\Streams\Exceptions\InvalidStreamResource;
use Aedart\Streams\Exceptions\StreamIsDetached;
use Aedart\Streams\FileStream;
use Aedart\Tests\TestCases\Streams\StreamTestCase;
use Codeception\Attribute\Group;
use GuzzleHttp\Psr7\Stream as PsrStream;
use PHPUnit\Framework\Attributes\Test;

/**
 * C0_AppendTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Streams\File
 */
#[Group(
    'streams',
    'stream-file',
    'stream-file-c0',
)]
class C0_AppendTest extends StreamTestCase
{
    /**
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function canAppendStringData()
    {
        $data = $this->getFaker()->realText(50);

        $stream = FileStream::openMemory()
            ->append($data)
            ->positionToStart();

        $this->assertSame($data, $stream->getContents());
    }

    /**
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function canAppendNumericData()
    {
        $data = $this->getFaker()->randomDigitNotNull();

        $stream = FileStream::openMemory()
            ->append($data)
            ->positionToStart();

        $this->assertSame((string) $data, $stream->getContents());
    }

    /**
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function canAppendDataFromResource()
    {
        $data = $this->getFaker()->realText(50);

        $source = FileStream::openMemory()
            ->put($data)
            ->positionToStart();

        $stream = FileStream::openMemory()
            ->append($source->detach())
            ->positionToStart();

        $this->assertSame($data, $stream->getContents());
    }

    /**
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function canAppendFromPsrStream()
    {
        $data = $this->getFaker()->realText(50);

        $resource = fopen('php://memory', 'r+b');
        $psrStream = new PsrStream($resource);
        $psrStream->write($data);
        $psrStream->rewind();

        $stream = FileStream::openMemory()
            ->append($psrStream)
            ->positionToStart();

        $this->assertSame($data, $stream->getContents());
        $this->assertNull($psrStream->detach(), 'Psr stream should had been detached');
    }

    /**
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function canAppendFromAnotherStream()
    {
        $data = $this->getFaker()->realText(50);

        $source = FileStream::openMemory()
            ->put($data)
            ->positionToStart();

        $stream = FileStream::openMemory()
            ->append($source)
            ->positionToStart();

        $this->assertSame($data, $stream->getContents());
        $this->assertFalse($source->isDetached(), 'Source stream should NOT be detached');
    }

    /**
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function failsIfDataStreamIsDetached()
    {
        $this->expectException(CannotCopyToTargetStream::class);

        $data = $this->getFaker()->realText(50);
        $source = FileStream::openMemory()
            ->put($data)
            ->positionToStart();

        $source->detach();

        FileStream::openMemory()
            ->append($source)
            ->positionToStart();
    }

    /**
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function failsIfTargetStreamIsDetached()
    {
        // Note: append() will attempt to move position to end on
        // target stream. Thus, it will never in this case hit the
        // "overhead" check if stream is detached in the internal
        // performCopy() method...
        $this->expectException(StreamIsDetached::class);
        //        $this->expectException(CannotCopyToTargetStream::class);

        $data = $this->getFaker()->realText(50);
        $source = FileStream::openMemory()
            ->put($data)
            ->positionToStart();

        $stream = FileStream::openMemory();
        $stream->detach();

        $stream->append($source);
    }

    /**
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function failsAppendIfDataTypeNotSupported()
    {
        $this->expectException(InvalidStreamResource::class);

        $data = [1, 2, 3];

        FileStream::openMemory()
            ->append($data);
    }
}
