<?php

namespace Aedart\Tests\Integration\Streams\File;

use Aedart\Streams\FileStream;
use Aedart\Tests\TestCases\Streams\StreamTestCase;

/**
 * E0_FlushTest
 *
 * @group streams
 * @group streams-file-e0
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Streams\File
 */
class E0_FlushTest extends StreamTestCase
{
    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    public function canFlushBufferedToFile()
    {
        // Hmm... not sure how this should be tested. Perhaps this does
        // not even make sense to test. Suppose that if no exceptions
        // are raised then test is a success...

        $data = $this->getFaker()->realText(50);

        $stream = FileStream::openTemporary('r+b', 25)
            ->put($data)
            ->flush();

        $this->assertSame($data, (string) $stream);
    }
}
