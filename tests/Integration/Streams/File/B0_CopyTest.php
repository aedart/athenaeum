<?php

namespace Aedart\Tests\Integration\Streams\File;

use Aedart\Contracts\Streams\Exceptions\StreamException;
use Aedart\Streams\FileStream;
use Aedart\Tests\TestCases\Streams\StreamTestCase;

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
}
