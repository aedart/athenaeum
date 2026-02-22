<?php

namespace Aedart\Contracts\Streams\Transactions;

use Aedart\Contracts\Streams\Exceptions\TransactionException;
use Aedart\Contracts\Streams\Stream;
use Throwable;

/**
 * Transactions
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Streams\Transactions
 */
interface Transactions extends TransactionFactoryAware
{
    /**
     * Processes operation within transaction
     *
     * @see Transaction::process()
     *
     * @param  callable(Stream|null $processStream, static $stream): mixed  $operation Operation callback is given a {@see Stream} and this
     *                              transaction instance as arguments.
     * @param  int  $attempts  [optional] Maximum amount of attempts to perform operation
     * @param  string|null  $profile  [optional] Transaction profile driver to use. If `null`, then a default driver is used.
     * @param  array  $options  [optional] Transaction driver specific options
     *
     * @return mixed
     *
     * @throws TransactionException
     * @throws Throwable
     */
    public function transaction(
        callable $operation,
        int $attempts = 1,
        string|null $profile = null,
        array $options = []
    ): mixed;
}
