<?php

namespace Aedart\Tests\Integration\Streams;

use Aedart\Streams\Stream;
use Aedart\Tests\TestCases\Streams\StreamTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * E0_WriteTest
 *
 * @group streams
 * @group streams-e0
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Streams
 */
#[Group(
    'streams',
    'stream-e0',
)]
class E0_WriteTest extends StreamTestCase
{
    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function canDetermineIfWritable()
    {
        $streamA = $this->makeTextFileStream('r+b');
        $streamB = $this->makeTextFileStream('rb');

        $this->assertTrue($streamA->isWritable());
        $this->assertFalse($streamB->isWritable());
    }

    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function canWrite()
    {
        $resource = fopen('php://memory', 'r+b');
        $stream = Stream::make($resource);

        $content = $this->getFaker()->word();
        $bytesWritten = $stream->write($content);

        $this->assertSame(strlen($content), $bytesWritten);
        $this->assertSame($content, (string) $stream);
    }

    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function canWriteViaPut()
    {
        $resource = fopen('php://memory', 'r+b');
        $stream = Stream::make($resource);

        $faker = $this->getFaker();
        $contentA = $faker->unique()->word();
        $contentB = $faker->unique()->word();
        $contentC = $faker->unique()->word();

        $stream
            ->put($contentA)
            ->put($contentB)
            ->put($contentC);

        $expected = "{$contentA}{$contentB}{$contentC}";
        $this->assertSame($expected, (string) $stream);
    }
}
