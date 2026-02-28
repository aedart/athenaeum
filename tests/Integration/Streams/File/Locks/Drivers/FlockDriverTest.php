<?php

namespace Aedart\Tests\Integration\Streams\File\Locks\Drivers;

use Aedart\Contracts\Streams\Locks\LockType;
use Aedart\Streams\Exceptions\Locks\LockFailure;
use Aedart\Streams\Exceptions\Locks\StreamCannotBeLocked;
use Aedart\Streams\FileStream;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Streams\StreamTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * FlockDriverTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Streams\File\Locks\Drivers
 */
#[Group(
    'streams',
    'stream-lock',
    'stream-lock-drivers',
    'stream-lock-driver-flock',
)]
class FlockDriverTest extends StreamTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Returns name of "flock" driver profile
     *
     * @return string
     */
    public function lockProfile(): string
    {
        return 'flock';
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\LockException
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function canAcquireAndReleaseLock()
    {
        $stream = $this->openFileStreamFor('text.txt');
        $lock = $this->makeLock($stream, $this->lockProfile());

        $wasAcquired = $lock->acquire();

        $this->assertTrue($wasAcquired);
        $this->assertTrue($lock->isAcquired(), 'Should be acquired');
        $this->assertFalse($lock->isReleased(), 'Should be not be released');

        $lock->release();

        $this->assertFalse($lock->isAcquired(), 'Should be no longer be acquired');
        $this->assertTrue($lock->isReleased(), 'Should be released');
    }

    /**
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\LockException
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function hasCorrectStreamReference()
    {
        $stream = $this->openFileStreamFor('text.txt');
        $lock = $this->makeLock($stream, $this->lockProfile());

        $this->assertSame($stream, $lock->getStream());
    }

    /**
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\LockException
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function failsAcquireIfAlreadyLocked()
    {
        $streamA = $this->openFileStreamFor('text.txt');
        $streamB = $this->openFileStreamFor('text.txt');

        $lockA = $this->makeLock($streamA, $this->lockProfile());
        $lockA->acquire();
        $this->assertTrue($lockA->isAcquired(), 'First lock was not acquired');

        $hasFailed = false;
        $failureMsg = '';
        try {
            $lockB = $this->makeLock($streamB, $this->lockProfile());
            $lockB->acquire(LockType::EXCLUSIVE, 0.01);
        } catch (LockFailure $e) {
            ConsoleDebugger::output($e->getMessage());

            $failureMsg = $e->getMessage();
            $hasFailed = true;
        }

        $this->assertTrue($hasFailed, 'Second lock did not fail, but should have');
        $this->assertStringContainsString('Timeout has been reached', $failureMsg);
        $lockA->release();
    }

    /**
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\LockException
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function failsAcquiringIfLockTypeIsUnknown()
    {
        $this->expectException(LockFailure::class);

        $stream = $this->openFileStreamFor('text.txt');
        $lock = $this->makeLock($stream, $this->lockProfile());

        $lock->acquire(999999, 0.01);
    }

    /**
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\LockException
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function failsWhenStreamDoesNotSupportLocking()
    {
        $this->expectException(StreamCannotBeLocked::class);

        $stream = FileStream::openMemory();
        $lock = $this->makeLock($stream, $this->lockProfile());

        $lock->acquire();
    }
}
