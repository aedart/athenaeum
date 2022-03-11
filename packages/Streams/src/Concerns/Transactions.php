<?php

namespace Aedart\Streams\Concerns;

use Aedart\Contracts\Streams\Transactions\Factory;
use Aedart\Streams\Traits\TransactionFactoryTrait;
use Aedart\Streams\Transactions\TransactionFactory;
use Aedart\Support\Facades\IoCFacade;

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
        return $this
            ->getTransactionFactory()
            ->create($this, $profile, $options)
            ->process($operation, $attempts);
    }

    /**
     * @inheritDoc
     */
    public function getDefaultTransactionFactory(): Factory|null
    {
        return IoCFacade::tryMake(Factory::class, new TransactionFactory());
    }
}
