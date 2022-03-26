<?php

namespace Aedart\Tests\Integration\Streams\File;

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
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    public function canCopyStream()
    {
        $data = $this->getFaker()->realText(25);
        $stream = FileStream::openMemory()
            ->put($data)
            ->positionToStart();

        $copy = $stream->copy();

        $this->assertSame($stream->getContents(), $copy->getContents());
    }

    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    public function canCopyToTargetStream()
    {
        $data = $this->getFaker()->realText(25);

        $target = FileStream::openMemory();
        $stream = FileStream::openMemory()
            ->put($data)
            ->positionToStart()
            ->copyTo($target);

        $this->assertSame($stream->getContents(), $target->getContents());
    }
}
