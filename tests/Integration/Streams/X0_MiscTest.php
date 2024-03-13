<?php

namespace Aedart\Tests\Integration\Streams;

use Aedart\Streams\Stream;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Streams\StreamTestCase;

/**
 * X0_MiscTest
 *
 * @group streams
 * @group streams-x0
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Streams
 */
class X0_MiscTest extends StreamTestCase
{
    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    public function canSetAndDetermineBlockingMode()
    {
        $streamA = $this->makeTextFileStream()
            ->setBlocking(false);

        $streamB = $this->makeTextFileStream()
            ->setBlocking(true);

        $this->assertFalse($streamA->blocked());
        $this->assertTrue($streamB->blocked());
    }

    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    public function canSetTimeout()
    {
        $resource = fsockopen('udp://127.0.0.1', 13);
        $stream = Stream::make($resource)
            ->setTimeout(0, 50);

        $stream->readLine();

        $this->assertTrue($stream->timedOut());
    }

    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    public function canObtainStreamResource()
    {
        $resource = fopen('php://memory', 'rb');
        $stream = Stream::make($resource);

        $this->assertSame($resource, $stream->resource());
    }

    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    public function canDetermineUnreadBytes()
    {
        // Note: not sure how a test should be written for "unread bytes".
        // Docs. claim that value is "contained in the PHP's own internal buffer",
        // and that it shouldn't be used...
        $stream = $this->makeTextFileStream('r');

        //        $this->assertGreaterThan(0, $stream->unreadBytes());
        $this->assertIsInt($stream->unreadBytes());
    }

    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    public function canGetResourceId()
    {
        $result = $this->makeTextFileStream('r')
            ->id();

        ConsoleDebugger::output($result);

        $this->assertNotEmpty($result);
    }

    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    public function canDetermineResourceType()
    {
        $result = $this->makeTextFileStream('r')
            ->type();

        ConsoleDebugger::output($result);

        $this->assertSame('stream', $result);
    }

    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    public function canDetermineStreamType()
    {
        $result = $this->makeTextFileStream('r')
            ->streamType();

        ConsoleDebugger::output($result);

        $this->assertSame('STDIO', $result);
    }

    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    public function canDetermineWrapperType()
    {
        $result = $this->makeTextFileStream('r')
            ->wrapperType();

        ConsoleDebugger::output($result);

        $this->assertSame('plainfile', $result);
    }

    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    public function canObtainWrapperData()
    {
        $resource = fopen('https://www.google.com', 'r');
        $result = Stream::make($resource)
            ->wrapperData();

        ConsoleDebugger::output($result);

        $this->assertNotEmpty($result);
    }

    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    public function canDetermineMode()
    {
        $mode = 'rb';
        $result = $this->makeTextFileStream($mode)
            ->mode();

        ConsoleDebugger::output($result);

        $this->assertSame($mode, $result);
    }

    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    public function canDetermineUri()
    {
        $path = $this->filePath('text.txt');
        $result = $this->makeTextFileStream()
            ->uri();

        ConsoleDebugger::output($result);

        $this->assertSame($path, $result);
    }

    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    public function canDetermineIfLocal()
    {
        $resource = fopen('https://www.google.com', 'r');
        $remoteStream = Stream::make($resource);
        $localStream = $this->makeTextFileStream();

        $this->assertFalse($remoteStream->isLocal(), 'Remote cannot be local');
        $this->assertTrue($remoteStream->isRemote(), 'Remote should be "remote"');

        $this->assertTrue($localStream->isLocal(), 'Local should be "local"');
        $this->assertFalse($localStream->isRemote(), 'Local cannot be "remote"');
    }

    /**
     * Disabled TTY tests due to lack of support from GitHub Actions.
     * This may have to be addressed at some point, if relevant
     *
     * @see https://github.com/actions/runner/issues/241
     *
     * test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    public function canDetermineIfTTY()
    {
        $resource = fopen('php://stderr', 'w');
        $streamA = Stream::make($resource);
        $streamB = $this->makeTextFileStream();

        $this->assertTrue($streamA->isTTY(), 'Should be TTY');
        $this->assertFalse($streamB->isTTY(), 'Should not be TTY');
    }

    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    public function canGetDebugInfo()
    {
        $streamA = new Stream();
        $streamB = $this->makeTextFileStream();

        $infoA = $streamA->__debugInfo();
        $infoB = $streamA->__debugInfo();

        // If no failure, then assumed success
        $this->assertNotEmpty($infoA);
        $this->assertNotEmpty($infoB);
    }
}
