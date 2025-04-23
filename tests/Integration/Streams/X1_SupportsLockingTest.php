<?php

namespace Aedart\Tests\Integration\Streams;

use Aedart\Tests\TestCases\Streams\StreamTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * X1_SupportsLockingTest
 *
 * @group streams
 * @group streams-x1
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Streams
 */
#[Group(
    'streams',
    'stream-x1',
)]
class X1_SupportsLockingTest extends StreamTestCase
{
    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function canDetermineIfLockingIsSupported()
    {
        $stream = $this->makeTextFileStream();

        $this->assertTrue($stream->supportsLocking());
    }

    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function canDetermineViaCustomCallback()
    {
        $stream = $this->makeTextFileStream()
            ->setSupportsLockingCallback(fn () => false);

        $this->assertFalse($stream->supportsLocking());
    }
}
