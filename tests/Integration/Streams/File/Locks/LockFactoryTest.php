<?php

namespace Aedart\Tests\Integration\Streams\File\Locks;

use Aedart\Contracts\Streams\Locks\Factory;
use Aedart\Contracts\Streams\Locks\Lock;
use Aedart\Streams\Exceptions\Locks\ProfileNotFound;
use Aedart\Streams\FileStream;
use Aedart\Tests\TestCases\Streams\StreamTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * LockFactoryTest
 *
 * @group streams
 * @group stream-lock
 * @group stream-lock-factory
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Streams\File\Locks
 */
#[Group(
    'streams',
    'stream-lock',
    'stream-lock-factory',
)]
class LockFactoryTest extends StreamTestCase
{
    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function canObtainInstance()
    {
        $factory = $this->getLockFactory();

        $this->assertInstanceOf(Factory::class, $factory);
    }

    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\LockException
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function canCreateLock()
    {
        $stream = FileStream::makeFrom(
            $this->makeTextFileStream()
        );

        $factory = $this->getLockFactory();
        $lock = $factory->create($stream);

        $this->assertInstanceOf(Lock::class, $lock);
    }

    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\LockException
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function failsIfProfileNotFound()
    {
        $this->expectException(ProfileNotFound::class);

        $stream = FileStream::makeFrom(
            $this->makeTextFileStream()
        );

        $factory = $this->getLockFactory();
        $factory->create($stream, 'unknown_profile');
    }
}
