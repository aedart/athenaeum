<?php

namespace Aedart\Tests\Integration\Streams;

use Aedart\Streams\Stream;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Streams\StreamTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * D0_ReadTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Streams
 */
#[Group(
    'streams',
    'stream-d0',
)]
class D0_ReadTest extends StreamTestCase
{
    /**
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function canDetermineIfReadable()
    {
        $streamA = $this->makeTextFileStream('rb');
        $streamB = $this->makeTextFileStream('a');

        $this->assertTrue($streamA->isReadable());
        $this->assertFalse($streamB->isReadable());
    }

    /**
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function canReadBytesFromStream()
    {
        $stream = $this->makeTextFileStream();

        $contents = $stream->read(10);

        ConsoleDebugger::output($contents);

        $this->assertNotEmpty($contents);
        $this->assertSame(10, strlen($contents));
    }

    /**
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function canGetContents()
    {
        $content = $this->getFaker()->sentence();
        $resource = fopen('php://memory', 'r+b');
        fwrite($resource, $content);

        // NOTE: getContents only returns remaining content,
        // so here we rewind!
        $stream = Stream::make($resource)
            ->positionToStart();

        $result = $stream->getContents();

        ConsoleDebugger::output([
            'expected' => $content,
            'actual' => $result
        ]);

        $this->assertSame($content, $result);
    }

    /**
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function returnsRemainingContents()
    {
        $content = 'abc';
        $resource = fopen('php://memory', 'r+b');
        fwrite($resource, $content);

        $stream = Stream::make($resource)
            ->positionAt(2);

        $result = $stream->getContents();
        $expected = 'c';

        ConsoleDebugger::output([
            'expected' => $expected,
            'actual' => $result
        ]);

        $this->assertSame($expected, $result);
    }

    /**
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function toStringReturnsAllContent()
    {
        $content = $this->getFaker()->sentence();
        $resource = fopen('php://memory', 'r+b');
        fwrite($resource, $content);

        $stream = Stream::make($resource)
            ->positionToEnd();

        $result = (string) $stream;

        ConsoleDebugger::output([
            'expected' => $content,
            'actual' => $result
        ]);

        $this->assertSame($content, $result);
    }
}
