<?php

namespace Aedart\Contracts\Streams\Transactions;

use Aedart\Contracts\Streams\Exceptions\TransactionException;
use Aedart\Contracts\Streams\Stream;

/**
 * Stream Transaction Factory
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Streams\Transactions
 */
interface Factory
{
    /**
     * Creates a new transaction instance for given stream
     *
     * @param  Stream  $stream
     * @param  string|null  $profile  [optional] Name of profile driver to use. If `null` is given,
     *                               then a default driver will be used.
     * @param  array  $options  [optional] Driver specific options
     *
     * @return Transaction
     *
     * @throws TransactionException
     */
    public function create(Stream $stream, string|null $profile = null, array $options = []): Transaction;
}
