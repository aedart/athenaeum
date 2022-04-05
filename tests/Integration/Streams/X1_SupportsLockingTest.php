<?php

namespace Aedart\Tests\Integration\Streams;

use Aedart\Tests\TestCases\Streams\StreamTestCase;

/**
 * X1_SupportsLockingTest
 *
 * @group streams
 * @group streams-x1
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Streams
 */
class X1_SupportsLockingTest extends StreamTestCase
{
    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    public function canDetermineIfLockingIsSupported()
    {
        $stream = $this->makeTextFileStream();

        $this->assertTrue($stream->supportsLocking());
    }

    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    public function canDetermineViaCustomCallback()
    {
        $stream = $this->makeTextFileStream()
            ->setSupportsLockingCallback(fn() => false);

        $this->assertFalse($stream->supportsLocking());
    }
}
