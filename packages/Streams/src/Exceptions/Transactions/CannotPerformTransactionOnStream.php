<?php

namespace Aedart\Streams\Exceptions\Transactions;

/**
 * Cannot Perform Transaction On Stream Exception
 *
 * Should be thrown is transaction cannot be performed on a stream, e.g.
 * the type of stream is not supported.
 * 
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Streams\Exceptions\Transactions
 */
class CannotPerformTransactionOnStream extends TransactionException
{
}
