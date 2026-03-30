<?php

namespace Aedart\Tests\Integration\Streams;

use Aedart\Streams\Exceptions\StreamAlreadyOpened;
use Aedart\Streams\Stream;
use Aedart\Tests\TestCases\Streams\StreamTestCase;
use Codeception\Attribute\Group;
use GuzzleHttp\Psr7\Stream as PsrStream;
use PHPUnit\Framework\Attributes\Test;

/**
 * A1_OpenCloseTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Streams
 */
#[Group(
    'streams',
    'stream-a1',
)]
class A1_OpenCloseTest extends StreamTestCase
{
    /**
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function canCreateViaMake()
    {
        $resource = fopen('php://memory', 'r+b');
        $stream = Stream::make($resource, [ 'foo' => 'bar' ]);

        $this->assertFalse($stream->isDetached());
        $this->assertTrue($stream->isOpen());
        $this->assertSame('bar', $stream->getMetadata('foo'));
    }

    /**
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function canCreateFromPsr7Stream()
    {
        $resource = fopen('php://memory', 'r+b');
        $psrStream = new PsrStream($resource);

        $stream = Stream::makeFrom($psrStream);

        $this->assertFalse($stream->isDetached());
        $this->assertTrue($stream->isOpen());

        // Psr-7 Streams should be detached. This means that invoking the
        // detach method again should yield null.
        $detached = $psrStream->detach();
        $this->assertNull($detached, 'Psr-7 Stream was not detached');
    }

    /**
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function canOpenUsingCallback()
    {
        $stream = new Stream();
        $this->assertFalse($stream->isOpen());

        $stream->openUsing(function () {
            return fopen('php://memory', 'r+b');
        });
        $this->assertTrue($stream->isOpen());
    }

    /**
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function failsOpeningViaCallbackIfAlreadyOpen()
    {
        $this->expectException(StreamAlreadyOpened::class);

        $resource = fopen('php://memory', 'r+b');
        $stream = Stream::make($resource);

        $stream->openUsing(function () {
            return fopen('php://memory', 'r+b');
        });
    }

    /**
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function canDetachStream()
    {
        $resource = fopen('php://memory', 'r+b');
        $stream = Stream::make($resource);

        $detached = $stream->detach();

        $this->assertSame($resource, $detached);
        $this->assertTrue($stream->isDetached());
        $this->assertFalse($stream->isOpen());
    }

    /**
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function canCloseStream()
    {
        $resource = fopen('php://memory', 'r+b');
        $stream = Stream::make($resource);
        $stream->close();

        $this->assertTrue($stream->isDetached());
        $this->assertFalse($stream->isOpen());
        $this->assertNull($stream->detach());
    }

    /**
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function automaticallyClosesWhenDestructed()
    {
        $resource = fopen('php://memory', 'r+b');
        $stream = Stream::make($resource);
        unset($stream);

        $this->assertFalse(is_resource($resource));
    }
}
