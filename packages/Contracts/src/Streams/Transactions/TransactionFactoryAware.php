<?php

namespace Aedart\Contracts\Streams\Transactions;

/**
 * Transaction Factory Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Streams\Transactions
 */
interface TransactionFactoryAware
{
    /**
     * Set transaction factory
     *
     * @param  Factory|null  $factory  Transaction factory instance
     *
     * @return self
     */
    public function setTransactionFactory(Factory|null $factory): static;

    /**
     * Get transaction factory
     *
     * If no transaction factory has been set, this method will
     * set and return a default transaction factory, if any such
     * value is available
     *
     * @return Factory|null transaction factory or null if none transaction factory has been set
     */
    public function getTransactionFactory(): Factory|null;

    /**
     * Check if transaction factory has been set
     *
     * @return bool True if transaction factory has been set, false if not
     */
    public function hasTransactionFactory(): bool;

    /**
     * Get a default transaction factory value, if any is available
     *
     * @return Factory|null A default transaction factory value or Null if no default value is available
     */
    public function getDefaultTransactionFactory(): Factory|null;
}
