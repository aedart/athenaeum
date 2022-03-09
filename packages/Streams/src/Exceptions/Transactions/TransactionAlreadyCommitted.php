<?php

namespace Aedart\Streams\Exceptions\Transactions;

/**
 * Transaction Already Committed Exception
 *
 * Should be thrown when a transaction is attempted committed or rolled backed,
 * but was already committed.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Streams\Exceptions\Transactions
 */
class TransactionAlreadyCommitted extends TransactionException
{
}
