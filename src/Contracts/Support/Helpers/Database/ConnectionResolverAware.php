<?php

namespace Aedart\Contracts\Support\Helpers\Database;

use Illuminate\Database\ConnectionResolverInterface;

/**
 * Connection Resolver Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Helpers\Database
 */
interface ConnectionResolverAware
{
    /**
     * Set connection resolver
     *
     * @param ConnectionResolverInterface|null $resolver Connection Resolver instance
     *
     * @return self
     */
    public function setConnectionResolver(?ConnectionResolverInterface $resolver);

    /**
     * Get connection resolver
     *
     * If no connection resolver has been set, this method will
     * set and return a default connection resolver, if any such
     * value is available
     *
     * @see getDefaultConnectionResolver()
     *
     * @return ConnectionResolverInterface|null connection resolver or null if none connection resolver has been set
     */
    public function getConnectionResolver(): ?ConnectionResolverInterface;

    /**
     * Check if connection resolver has been set
     *
     * @return bool True if connection resolver has been set, false if not
     */
    public function hasConnectionResolver(): bool;

    /**
     * Get a default connection resolver value, if any is available
     *
     * @return ConnectionResolverInterface|null A default connection resolver value or Null if no default value is available
     */
    public function getDefaultConnectionResolver(): ?ConnectionResolverInterface;
}
