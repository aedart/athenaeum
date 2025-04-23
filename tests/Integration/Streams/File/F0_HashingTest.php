<?php

namespace Aedart\Tests\Integration\Streams\File;

use Aedart\Streams\FileStream;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Streams\StreamTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * F0_HashingTest
 *
 * @group streams
 * @group streams-file-f0
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Streams\File
 */
#[Group(
    'streams',
    'stream-file',
    'stream-file-f0',
)]
class F0_HashingTest extends StreamTestCase
{
    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function canObtainHashOfStreamsContent()
    {
        $algo = 'xxh3';
        $data = $this->getFaker()->realText(50);

        $stream = FileStream::openTemporary('r+b', 25)
            ->put($data);

        $result = $stream->hash($algo);
        ConsoleDebugger::output($result);

        $this->assertNotEmpty($result);
        $this->assertTrue(hash_equals(hash($algo, $data), $result), 'Invalid content hash');
    }
}
