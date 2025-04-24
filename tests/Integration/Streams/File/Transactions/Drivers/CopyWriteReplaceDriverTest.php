<?php

namespace Aedart\Tests\Integration\Streams\File\Transactions\Drivers;

use Aedart\Contracts\Streams\Exceptions\TransactionException;
use Aedart\Contracts\Streams\FileStream;
use Aedart\Contracts\Streams\Transactions\Transaction;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Streams\StreamTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;
use RuntimeException;

/**
 * CopyWriteReplaceDriverTest
 *
 * @group streams
 * @group stream-transaction
 * @group stream-transaction-drivers
 * @group stream-transaction-driver-cwr
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Streams\File\Transactions\Drivers
 */
#[Group(
    'streams',
    'stream-transaction',
    'stream-transaction-drivers',
    'stream-transaction-driver-cwr',
)]
class CopyWriteReplaceDriverTest extends StreamTestCase
{
    /**
     * @inheritDoc
     */
    protected function _before()
    {
        parent::_before();

        // Clear evt. backup files...
        $fs = $this->getFile();
        $fs->cleanDirectory($this->backupDir());
    }


    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Returns name of transaction profile to use
     *
     * @return string
     */
    public function transactionProfile(): string
    {
        return 'cwr';
    }

    /**
     * Backup dir for this transaction driver
     *
     * @return string
     *
     * @throws \Codeception\Exception\ConfigurationException
     */
    public function backupDir(): string
    {
        return $this->outputDir() . DIRECTORY_SEPARATOR . 'backup';
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     *
     * @return void
     *
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     * @throws \Aedart\Contracts\Streams\Exceptions\TransactionException
     * @throws \Codeception\Exception\ConfigurationException
     */
    #[Test]
    public function canProcessOperationWithinTransaction()
    {
        $stream = $this->openFileStreamForTransaction('text.txt');

        $factory = $this->getTransactionFactory();
        $transaction = $factory->create($stream, $this->transactionProfile());

        $newData = $this->getFaker()->realText();
        $hasProcessed = false;
        $transaction->process(function (FileStream $processStream, Transaction $transaction) use ($newData, &$hasProcessed) {
            $this->assertNotNull($transaction->stream(), 'Transaction lost reference to transaction');

            $processStream->append($newData);
            $hasProcessed = true;
        });

        $this->assertTrue($hasProcessed, 'operation not processed');
        $this->assertStringContainsString($newData, (string) $stream, 'operation didnt append data');
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     * @throws \Aedart\Contracts\Streams\Exceptions\TransactionException
     * @throws \Codeception\Exception\ConfigurationException
     * @throws \Throwable
     */
    #[Test]
    public function takesBackupOfOriginalStream()
    {
        // NOTE: Test profile has backup enabled!

        $stream = $this->openFileStreamForTransaction('text.txt');

        $factory = $this->getTransactionFactory();
        $transaction = $factory->create($stream, $this->transactionProfile());

        $transaction->process(fn () => true);

        // ----------------------------------------------------------------- //

        $fs = $this->getFile();
        $files = $fs->files($this->backupDir());

        ConsoleDebugger::output($files);

        $this->assertNotEmpty($files);
        $first = $files[0];

        $this->assertStringContainsString('text.txt', $first->getFilename());
        $this->assertSame($stream->getSize(), $first->getSize(), 'Invalid backup filesize');
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws TransactionException
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     * @throws \Codeception\Exception\ConfigurationException
     * @throws \Throwable
     */
    #[Test]
    public function canRemoveBackupAfterCompletion()
    {
        $stream = $this->openFileStreamForTransaction('text.txt');

        $factory = $this->getTransactionFactory();
        $transaction = $factory->create($stream, $this->transactionProfile(), [
            'backup' => [
                'enabled' => true,
                'directory' => $this->backupDir(),
                'remove_after_commit' => true,
            ]
        ]);

        $transaction->process(fn () => true);

        // ----------------------------------------------------------------- //

        $fs = $this->getFile();
        $files = $fs->files($this->backupDir());

        ConsoleDebugger::output($files);

        $this->assertEmpty($files, 'One or more backup files still remain');
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws TransactionException
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     * @throws \Codeception\Exception\ConfigurationException
     * @throws \Throwable
     */
    #[Test]
    public function canRecoverOriginalContentOnFailure()
    {
        $stream = $this->openFileStreamForTransaction('text.txt');

        $factory = $this->getTransactionFactory();
        $transaction = $factory->create($stream, $this->transactionProfile());

        $failMsg = '@test - transaction recover org. content test';
        $captured = false;

        try {
            $transaction->process(function (FileStream $processStream) use ($failMsg) {
                $processStream->truncate(0);
                throw new RuntimeException($failMsg);
            });
        } catch (TransactionException $e) {
            $captured = true;
            $this->assertSame($failMsg, $e->getMessage());
        }

        $this->assertTrue($captured, 'No failure captured');
        $this->assertGreaterThan(0, $stream->getSize(), 'Original stream content has not been recovered');
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws TransactionException
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     * @throws \Codeception\Exception\ConfigurationException
     * @throws \Throwable
     */
    #[Test]
    public function ableToPerformMultipleProcessAttempts()
    {
        $stream = $this->openFileStreamForTransaction('text.txt');

        $factory = $this->getTransactionFactory();
        $transaction = $factory->create($stream, $this->transactionProfile());

        $attempt = 0;
        $max = 3;
        $failMsg = '@test - transaction attempts test';

        try {
            $transaction->process(function () use (&$attempt, $failMsg) {
                $attempt++;

                throw new RuntimeException($failMsg);
            }, $max);
        } catch (TransactionException $e) {
            $this->assertSame($failMsg, $e->getMessage());
        }

        $this->assertSame($max, $attempt, 'Process failed to run multiple attempts');
    }
}
