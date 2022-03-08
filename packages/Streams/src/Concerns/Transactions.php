<?php

namespace Aedart\Streams\Concerns;

use Aedart\Streams\Traits\TransactionFactoryTrait;

/**
 * Transactions
 *
 * @see \Aedart\Contracts\Streams\Transactions\Transactions
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Streams\Concerns
 */
trait Transactions
{
    use TransactionFactoryTrait;

    // TODO: Default Transaction Factory

    /**
     * @inheritdoc
     */
    public function transaction(
        callable $operation,
        int $attempts = 1,
        string|null $profile = null,
        array $options = []
    ): mixed
    {
        // TODO: Implement method...
    }
}
