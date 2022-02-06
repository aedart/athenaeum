<?php

namespace Aedart\Contracts\Acl;

use Aedart\Contracts\Support\Helpers\Cache\CacheAware;
use DateInterval;
use DateTimeInterface;
use Illuminate\Contracts\Auth\Access\Gate;

/**
 * Acl Registrar
 *
 * Responsible for obtaining abilities (permissions) and define them for
 * a given access gate.
 *
 * @see Gate
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Contracts\Acl
 */
interface Registrar extends CacheAware
{
    /**
     * Defines the abilities (permissions) and how to
     * resolve them, for the given access gate.
     *
     * @see getPermissions
     *
     * @param Gate $gate
     * @param bool $force [optional] Force permissions to be read
     *                    from data storage. If false, then cached
     *                    permissions are used.
     *
     * @return self
     */
    public function define(Gate $gate, bool $force = false): static;

    /**
     * Returns the abilities (permissions) to be used
     *
     * @param bool $force [optional] Force permissions to be read
     *                    from data storage. If false, then cached
     *                    permissions are used.
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Aedart\Acl\Models\Permission[]
     */
    public function getPermissions(bool $force = false);

    /**
     * Flush the cached abilities (permissions)
     *
     * @return bool
     */
    public function flush(): bool;

    /**
     * Set the cached permissions' time-to-live (ttl)
     *
     * @param DateTimeInterface|DateInterval|int|null $ttl [optional] E.g. seconds
     *
     * @return self
     */
    public function expires($ttl = null): static;

    /**
     * Set the cache key to use when caching permissions
     *
     * @param string|null $name [optional]
     *
     * @return self
     */
    public function key(string|null $name = null): static;
}
