<?php

namespace Aedart\Streams\Exceptions\Transactions;

use Aedart\Contracts\Streams\Exceptions\TransactionException as TransactionExceptionInterface;
use RuntimeException;

/**
 * Transaction Exception
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Streams\Exceptions\Transactions
 */
class TransactionException extends RuntimeException implements TransactionExceptionInterface
{
}
