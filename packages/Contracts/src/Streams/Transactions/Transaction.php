<?php

namespace Aedart\Contracts\Streams\Transactions;

use Aedart\Contracts\Streams\Exceptions\TransactionException;
use Aedart\Contracts\Streams\Stream;
use Throwable;

/**
 * Stream Transaction
 *
 * Intended to allow performing "dangerous" write operation on a target
 * stream safely, before committing changes.
 *
 * Component is inspired by database transactions (in general), and Laravel's
 * transaction handling in their database package (illuminate/database).
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Streams\Transactions
 */
interface Transaction
{
    /**
     * Processes given operation within transaction
     *
     * Method will automatically begin transaction, if it's not already started. After the
     * operation has completed, transaction is automatically committed, if not already
     * committed.
     *
     * In case of failure (exceptions raised), method will attempt to process operation
     * again, if the maximum amount of retries has not been exceeded. If maximum retries
     * is reached, then transaction is rolled back and exception is thrown.
     *
     * @param  callable(Stream|null $processStream, static $stream): mixed  $operation Operation callback is given a {@see Stream} and this
     *                              transaction instance as arguments.
     * @param  int  $attempts  [optional] Maximum amount of attempts to perform operation
     *
     * @return mixed Eventual output from operation callback
     *
     * @throws TransactionException
     * @throws Throwable
     */
    public function process(callable $operation, int $attempts = 1): mixed;

    /**
     * Begin transaction
     *
     * Typically, this method locks the target stream and creates
     * a copy, which can be passed on to the {@see process()} method's
     * `$operation` callback argument. However, this depends on
     * the type of stream and transaction implementation.
     *
     * @return void
     *
     * @throws TransactionException
     */
    public function begin(): void;

    /**
     * Commit transaction
     *
     * Typically, this method will overwrite target stream's contents with
     * the contents of the processed stream. Upon completion, any eventual
     * locks are released. Yet, this depends on stream type and implementation
     * of transaction.
     *
     * **Note**: _Once the transaction is committed, the transaction cannot
     * be committed again, nor rolled back. Thus, this transaction instance
     * becomes useless for further interaction._
     *
     * @return void
     *
     * @throws TransactionException
     */
    public function commit(): void;

    /**
     * Rollback transaction
     *
     * Typically, this method will clean up target stream copy,
     * and release any acquired lock for target stream. This too, however,
     * depends on stream type and transaction implementation.
     *
     * **Note**: _If transaction is rolled back, the transaction
     * can neither be attempted committed nor rolled back again.
     * The transaction instance becomes useless for further
     * interaction._
     *
     * @return void
     *
     * @throws TransactionException
     */
    public function rollBack(): void;

    /**
     * Returns the processing stream
     *
     * Method will typically return a copy of the original target stream,
     * which can be safely be manipulated.
     *
     * @see begin()
     *
     * @return Stream|null Stream or `null` if transaction has not yet begun,
     *                     has already been committed or rolled back.
     */
    public function stream(): Stream|null;
}
