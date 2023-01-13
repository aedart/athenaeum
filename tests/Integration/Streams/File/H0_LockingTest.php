<?php

namespace Aedart\Tests\Integration\Streams\File;

use Aedart\Contracts\Streams\Locks\Lock;
use Aedart\Tests\TestCases\Streams\StreamTestCase;

/**
 * H0_LockingTest
 *
 * @group streams
 * @group streams-file-h0
 * @group stream-lock
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Streams\File
 */
class H0_LockingTest extends StreamTestCase
{
    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     * @throws \Throwable
     */
    public function canPerformOperationUsingExclusiveLock()
    {
        $stream = $this->openFileStreamFor('text.txt');

        $result = $stream->exclusiveLock(fn () => true, 0.01);

        $this->assertTrue($result);
    }

    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     * @throws \Throwable
     */
    public function canPerformOperationUsingSharedLock()
    {
        $stream = $this->openFileStreamFor('text.txt');

        $result = $stream->sharedLock(fn () => true, 0.01);

        $this->assertTrue($result);
    }

    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     * @throws \Throwable
     */
    public function lockOperationReceivesIntendedArguments()
    {
        $stream = $this->openFileStreamFor('text.txt');

        $completed = false;
        $stream->exclusiveLock(function ($lockedStream, $lock) use ($stream, &$completed) {
            $this->assertSame($stream, $lockedStream, 'Invalid stream instance given');
            $this->assertInstanceOf(Lock::class, $lock);

            $completed = true;
        }, 0.01);

        $this->assertTrue($completed, 'lock operation not invoked!');
    }
}
