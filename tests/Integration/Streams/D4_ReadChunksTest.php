<?php

namespace Aedart\Tests\Integration\Streams;

use Aedart\Streams\Stream;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Streams\StreamTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * D4_ReadChunksTest
 *
 * @group streams
 * @group streams-d4
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Streams
 */
#[Group(
    'streams',
    'stream-d4',
)]
class D4_ReadChunksTest extends StreamTestCase
{
    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function canReadAllInChunks()
    {
        $content = "abc";
        $resource = fopen('php://memory', 'r+b');
        fwrite($resource, $content);

        $stream = Stream::make($resource)
            ->positionToStart();

        $buffer = '';
        $iterator = $stream->readAllInChunks(1);
        foreach ($iterator as $chunk) {
            ConsoleDebugger::output($chunk);

            $buffer .= $chunk;
        }

        $this->assertSame('abc', $buffer);
    }
}
