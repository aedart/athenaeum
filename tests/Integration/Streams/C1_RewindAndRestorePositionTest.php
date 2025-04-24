<?php

namespace Aedart\Tests\Integration\Streams;

use Aedart\Streams\Stream;
use Aedart\Tests\TestCases\Streams\StreamTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * C1_RewindAndRestorePositionTest
 *
 * @group streams
 * @group streams-c1
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Streams
 */
#[Group(
    'streams',
    'stream-c1',
)]
class C1_RewindAndRestorePositionTest extends StreamTestCase
{
    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function rewindsAfterCallbackInvoked()
    {
        $resource = fopen('php://memory', 'r+b');

        $stream = Stream::make($resource);

        $stream->rewindAfter(function (Stream $stream) {
            $res = $stream->resource();
            fwrite($res, 'aa');
            fseek($res, 0, SEEK_SET);

            while (!feof($res)) {
                fgets($res, 3);
            }
        });

        $this->assertSame(0, $stream->position());
        $this->assertFalse($stream->eof());
    }

    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function returnsRewindCallbackOutput()
    {
        $resource = fopen('php://memory', 'r+b');

        $stream = Stream::make($resource);

        $content = 'aaa';
        $output = $stream->rewindAfter(function (Stream $stream) use ($content) {
            $res = $stream->resource();
            fwrite($res, $content);
            fseek($res, 0, SEEK_SET);

            return stream_get_contents($res);
        });

        $this->assertSame($content, $output);
        $this->assertSame(0, $stream->position());
    }

    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function restoresPositionAfterCallbackInvoked()
    {
        $resource = fopen('php://memory', 'r+b');
        fwrite($resource, 'aa');
        fseek($resource, 0, SEEK_END);

        $stream = Stream::make($resource);
        $stream->restorePositionAfter(function (Stream $stream) {
            fseek($stream->resource(), 0, SEEK_SET);
        });

        $this->assertSame(2, $stream->position());
    }

    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function returnsRestoreCallbackOutput()
    {
        $content = 'bbb';
        $resource = fopen('php://memory', 'r+b');
        fwrite($resource, $content);
        fseek($resource, 0, SEEK_END);

        $stream = Stream::make($resource);

        $output = $stream->restorePositionAfter(function (Stream $stream) use ($content) {
            $res = $stream->resource();
            fseek($res, 0, SEEK_SET);

            return stream_get_contents($res);
        });

        $this->assertSame($content, $output);
        $this->assertSame(3, $stream->position());
    }
}
