<?php

namespace Aedart\Tests\Integration\Streams\File\Transactions;

use Aedart\Contracts\Streams\Transactions\Factory;
use Aedart\Contracts\Streams\Transactions\Transaction;
use Aedart\Streams\Exceptions\Transactions\ProfileNotFound;
use Aedart\Tests\TestCases\Streams\StreamTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * TransactionFactoryTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Streams\File\Transactions
 */
#[Group(
    'streams',
    'stream-transaction',
    'stream-transaction-factory',
)]
class TransactionFactoryTest extends StreamTestCase
{
    /**
     * @return void
     */
    public function canObtainInstance()
    {
        $factory = $this->getTransactionFactory();

        $this->assertInstanceOf(Factory::class, $factory);
    }

    /**
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     * @throws \Aedart\Contracts\Streams\Exceptions\TransactionException
     */
    #[Test]
    public function canCreateTransaction()
    {
        $stream = $this->openFileStreamFor('text.txt');
        $factory = $this->getTransactionFactory();

        $transaction = $factory->create($stream);

        $this->assertInstanceOf(Transaction::class, $transaction);
    }

    /**
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     * @throws \Aedart\Contracts\Streams\Exceptions\TransactionException
     */
    #[Test]
    public function failsIfProfileNotFound()
    {
        $this->expectException(ProfileNotFound::class);

        $stream = $this->openFileStreamFor('text.txt');
        $factory = $this->getTransactionFactory();

        $factory->create($stream, 'unknown_profile');
    }
}
