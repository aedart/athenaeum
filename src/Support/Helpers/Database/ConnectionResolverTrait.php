<?php

namespace Aedart\Support\Helpers\Database;

use Illuminate\Database\ConnectionResolverInterface;
use Illuminate\Support\Facades\DB;

/**
 * Connection Resolver Trait
 *
 * @see \Aedart\Contracts\Support\Helpers\Database\ConnectionResolverAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Helpers\Database
 */
trait ConnectionResolverTrait
{
    /**
     * Connection Resolver instance
     *
     * @var ConnectionResolverInterface|null
     */
    protected $connectionResolver = null;

    /**
     * Set connection resolver
     *
     * @param ConnectionResolverInterface|null $resolver Connection Resolver instance
     *
     * @return self
     */
    public function setConnectionResolver(?ConnectionResolverInterface $resolver)
    {
        $this->connectionResolver = $resolver;

        return $this;
    }

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
    public function getConnectionResolver(): ?ConnectionResolverInterface
    {
        if (!$this->hasConnectionResolver()) {
            $this->setConnectionResolver($this->getDefaultConnectionResolver());
        }
        return $this->connectionResolver;
    }

    /**
     * Check if connection resolver has been set
     *
     * @return bool True if connection resolver has been set, false if not
     */
    public function hasConnectionResolver(): bool
    {
        return isset($this->connectionResolver);
    }

    /**
     * Get a default connection resolver value, if any is available
     *
     * @return ConnectionResolverInterface|null A default connection resolver value or Null if no default value is available
     */
    public function getDefaultConnectionResolver(): ?ConnectionResolverInterface
    {
        return DB::getFacadeRoot();
    }
}
