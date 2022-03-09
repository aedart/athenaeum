<?php

namespace Aedart\Streams\Transactions\Drivers;

use Aedart\Contracts\Streams\Stream;
use Aedart\Contracts\Streams\Transactions\Transaction;
use Aedart\Streams\Exceptions\Transactions\FailedToCommitTransaction;
use Aedart\Streams\Exceptions\Transactions\FailedToRollbackTransaction;
use Aedart\Streams\Exceptions\Transactions\CannotPerformTransactionOnStream;
use Aedart\Streams\Exceptions\Transactions\TransactionAlreadyCommitted;
use Aedart\Streams\Exceptions\Transactions\TransactionAlreadyRunning;
use Aedart\Streams\Exceptions\Transactions\TransactionException;
use Aedart\Streams\Exceptions\Transactions\FailedToBeginTransaction;
use Aedart\Utils\Arr;
use Throwable;

/**
 * Base Transaction Driver
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Streams\Transactions\Drivers
 */
abstract class BaseTransactionDriver implements Transaction
{
    /**
     * The stream instance that will be passed to
     * the process operation callback
     *
     * @var Stream|null
     */
    protected Stream|null $processStream = null;

    /**
     * State whether transaction has started or not
     *
     * @var bool
     */
    protected bool $started = false;

    /**
     * State whether transaction has committed or not
     *
     * @var bool
     */
    protected bool $hasCommitted = false;

    /**
     * Creates new transaction driver instance
     *
     * @param  Stream  $originalStream The stream to be locked
     * @param  array  $options  [optional]
     */
    public function __construct(
        protected Stream $originalStream,
        protected array $options = []
    )
    {}

    /**
     * Determine if transaction can be performed for given stream
     *
     * @param  Stream  $stream
     *
     * @return bool
     */
    abstract public function canPerformTransaction(Stream $stream): bool;

    /**
     * Performs begin transaction
     *
     * @see begin()
     *
     * @param  Stream  $originalStream
     *
     * @return Stream The stream to be passed on to {@see process()} callback
     *
     * @throws Throwable
     */
    abstract public function performBegin(Stream $originalStream): Stream;

    /**
     * Performs commit transaction
     *
     * @see commit()
     *
     * @param  Stream  $processedStream Stream that was processed by {@see process()} callback
     * @param  Stream  $originalStream The original stream
     *
     * @return void
     *
     * @throws Throwable
     */
    abstract public function performCommit(Stream $processedStream, Stream $originalStream): void;

    /**
     * Performs rollback transaction
     *
     * @see rollback()
     *
     * @param  Stream  $processedStream Stream that was processed by {@see process()} callback
     * @param  Stream  $originalStream The original stream
     *
     * @return void
     *
     * @throws Throwable
     */
    abstract public function performRollback(Stream $processedStream, Stream $originalStream): void;

    /**
     * @inheritDoc
     */
    public function process(callable $operation, int $attempts = 1): mixed
    {
        // The process logic found here, is inspired by Laravel's transaction() method.
        // @see \Illuminate\Database\Concerns\ManagesTransactions::transaction()

        $result = null;

        for ($currentAttempt = 1; $currentAttempt <= $attempts; $currentAttempt++) {
            $this->begin();

            // Perform provided operation callback, using the "process stream".
            // In case of failure, we roll back and try again, if attempts
            // has not yet exceeded maximum.
            try {
                $result = $operation($this->stream(), $this);
            } catch (Throwable $e) {
                $this->handleOperationFailure($e, $currentAttempt, $attempts);
                continue;
            }

            // Commit the transaction. In case of failure, the same procedure is
            // followed as for handling failures during operation.
            try {
                $this->commit();
            } catch (Throwable $e) {
                $this->handleCommitFailure($e, $currentAttempt, $attempts);
                continue;
            }

            break;
        }

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function begin(): void
    {
        // Fail if already started
        if ($this->started) {
            throw new TransactionAlreadyRunning('Transaction has already been started');
        }

        $this
            ->failIfTransactionCannotBePerformed($this->originalStream())
            ->failIfAlreadyProcessed();

        try {
            $this->processStream = $this->performBegin($this->originalStream());
            $this->started = true;
        } catch (Throwable $e) {
            throw new FailedToBeginTransaction($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @inheritDoc
     */
    public function commit(): void
    {
        $this->failIfAlreadyProcessed();

        try {
            $this->performCommit($this->stream(), $this->originalStream());

            $this->hasCommitted = true;

            $this->close();
        } catch (Throwable $e) {
            throw new FailedToCommitTransaction($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @inheritDoc
     */
    public function rollBack(): void
    {
        $this->failIfAlreadyProcessed();

        try {
            $this->performRollback($this->stream(), $this->originalStream());
        } catch (Throwable $e) {
            throw new FailedToRollbackTransaction($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @inheritDoc
     */
    public function stream(): Stream|null
    {
        return $this->processStream;
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Handles process failure
     *
     * @param  Throwable  $e
     * @param  int  $currentAttempt
     * @param  int  $maxAttempts
     *
     * @return void
     *
     * @throws TransactionException
     */
    protected function handleOperationFailure(Throwable $e, int $currentAttempt, int $maxAttempts)
    {
        $this->rollBack();

        if ($currentAttempt < $maxAttempts) {
            return;
        }

        $this->wrapAndThrowException($e);
    }

    /**
     * Handles process commit failure
     *
     * @param  Throwable  $e
     * @param  int  $currentAttempt
     * @param  int  $maxAttempts
     *
     * @return void
     *
     * @throws TransactionException
     */
    protected function handleCommitFailure(Throwable $e, int $currentAttempt, int $maxAttempts)
    {
        // By default, the same failure handling will be performed for when a commit has failed.
        // Overwrite this method is a different kind of logic is required by your transaction.

        $this->handleOperationFailure($e, $currentAttempt, $maxAttempts);
    }

    /**
     * Wraps and throws exception
     *
     * @param  Throwable  $e
     *
     * @return void
     *
     * @throws TransactionException
     */
    protected function wrapAndThrowException(Throwable $e): void
    {
        if ($e instanceof TransactionException) {
            throw $e;
        }

        throw new TransactionException($e->getMessage(), $e->getCode(), $e);
    }

    /**
     * Returns the "original" stream to be processed within transaction
     *
     * @return Stream
     */
    protected function originalStream(): Stream
    {
        return $this->originalStream;
    }

    /**
     * Get option value
     *
     * @param  string  $key
     * @param  mixed|null  $default  [optional]
     *
     * @return mixed
     */
    protected function get(string $key, mixed $default = null): mixed
    {
        return Arr::get($this->options, $key, $default);
    }

    /**
     * Close this transaction
     *
     * @return self
     */
    protected function close(): static
    {
        $this->processStream = null;
        unset($this->originalStream);

        return $this;
    }

    /**
     * Fails if transaction cannot be performed on given stream
     *
     * @param  Stream  $stream
     *
     * @return self
     *
     * @throws CannotPerformTransactionOnStream
     */
    protected function failIfTransactionCannotBePerformed(Stream $stream): static
    {
        if (!$this->canPerformTransaction($stream)) {
            throw new CannotPerformTransactionOnStream(sprintf('Unable to perform transaction on given stream instance %s', $stream::class));
        }

        return $this;
    }

    /**
     * Asserts that transaction has not been committed
     *
     * @return self
     *
     * @throws TransactionAlreadyCommitted
     */
    protected function failIfAlreadyProcessed(): static
    {
        // Fail if already committed
        if ($this->hasCommitted) {
            throw new TransactionAlreadyCommitted('Transaction has already been committed. Unable to proceed');
        }

        return $this;
    }
}
