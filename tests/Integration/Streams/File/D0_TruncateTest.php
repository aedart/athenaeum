<?php

namespace Aedart\Tests\Integration\Streams\File;

use Aedart\Streams\FileStream;
use Aedart\Tests\TestCases\Streams\StreamTestCase;

/**
 * D0_TruncateTest
 *
 * @group streams
 * @group streams-file-d0
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Streams\File
 */
class D0_TruncateTest extends StreamTestCase
{
    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    public function canTruncateStream()
    {
        $data = $this->getFaker()->realText(50);

        $stream = FileStream::openMemory()
            ->put($data)
            ->truncate(0);

        $this->assertSame(0, $stream->getSize());
    }

    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    public function canTruncateStreamToSpecificSize()
    {
        $data = $this->getFaker()->realText(50);
        $size = 25;

        $stream = FileStream::openMemory()
            ->put($data)
            ->truncate($size);

        $this->assertSame($size, $stream->getSize());
    }
}
