<?php

namespace Aedart\Streams\Traits;

use Aedart\Contracts\Streams\Transactions\Factory;

/**
 * Transaction Factory Trait
 *
 * @see \Aedart\Contracts\Streams\Transactions\TransactionFactoryAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Streams\Traits
 */
trait TransactionFactoryTrait
{
    /**
     * Transaction factory instance
     *
     * @var Factory|null
     */
    protected Factory|null $transactionFactory = null;

    /**
     * Set transaction factory
     *
     * @param  Factory|null  $factory  Transaction factory instance
     *
     * @return self
     */
    public function setTransactionFactory(Factory|null $factory): static
    {
        $this->transactionFactory = $factory;

        return $this;
    }

    /**
     * Get transaction factory
     *
     * If no transaction factory has been set, this method will
     * set and return a default transaction factory, if any such
     * value is available
     *
     * @return Factory|null transaction factory or null if none transaction factory has been set
     */
    public function getTransactionFactory(): Factory|null
    {
        if (!$this->hasTransactionFactory()) {
            $this->setTransactionFactory($this->getDefaultTransactionFactory());
        }
        return $this->transactionFactory;
    }

    /**
     * Check if transaction factory has been set
     *
     * @return bool True if transaction factory has been set, false if not
     */
    public function hasTransactionFactory(): bool
    {
        return isset($this->transactionFactory);
    }

    /**
     * Get a default transaction factory value, if any is available
     *
     * @return Factory|null A default transaction factory value or Null if no default value is available
     */
    public function getDefaultTransactionFactory(): Factory|null
    {
        return null;
    }
}
