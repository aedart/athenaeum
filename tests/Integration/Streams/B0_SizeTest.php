<?php

namespace Aedart\Tests\Integration\Streams;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Streams\StreamTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * B0_SizeTest
 *
 * @group streams
 * @group streams-b0
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Streams
 */
#[Group(
    'streams',
    'stream-b0',
)]
class B0_SizeTest extends StreamTestCase
{
    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function canDetermineSize()
    {
        $stream = $this->makeTextFileStream();
        $result = $stream->getSize();

        ConsoleDebugger::output([ 'size' => $result ]);

        $this->assertGreaterThan(0, $result);
    }

    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function canCountStreamSize()
    {
        $stream = $this->makeTextFileStream();
        $size = $stream->getSize();

        $this->assertCount($size, $stream);
    }

    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function canObtainFormattedSize()
    {
        $stream = $this->makeTextFileStream();
        $result = $stream->getFormattedSize();

        ConsoleDebugger::output([ 'size' => $result ]);

        $this->assertNotEmpty($result);
    }
}
