<?php

namespace Aedart\Tests\Integration\Streams;

use Aedart\Contracts\Streams\Exceptions\StreamException;
use Aedart\Streams\Stream;
use Aedart\Tests\TestCases\Streams\StreamTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * A2_CloneTest
 *
 * @group streams
 * @group streams-a2
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Streams
 */
#[Group(
    'streams',
    'stream-a2',
)]
class A2_CloneTest extends StreamTestCase
{
    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function failsWhenAttemptingToClone()
    {
        $this->expectException(StreamException::class);

        $stream = new Stream();
        $clone = clone $stream;
    }
}
