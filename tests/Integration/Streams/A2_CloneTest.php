<?php

namespace Aedart\Tests\Integration\Streams;

use Aedart\Contracts\Streams\Exceptions\StreamException;
use Aedart\Streams\Stream;
use Aedart\Tests\TestCases\Streams\StreamTestCase;

/**
 * A2_CloneTest
 *
 * @group streams
 * @group streams-a2
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Streams
 */
class A2_CloneTest extends StreamTestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function failsWhenAttemptingToClone()
    {
        $this->expectException(StreamException::class);

        $stream = new Stream();
        $clone = clone $stream;
    }
}
