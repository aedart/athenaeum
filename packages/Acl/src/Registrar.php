<?php

namespace Aedart\Acl;

use Aedart\Acl\Models\Concerns\Configuration as AclConfiguration;
use Aedart\Acl\Models\Permission;
use Aedart\Acl\Traits\HasRoles;
use Aedart\Contracts\Acl\Registrar as RegistrarInterface;
use Aedart\Contracts\Support\Helpers\Cache\CacheFactoryAware;
use Aedart\Contracts\Support\Helpers\Config\ConfigAware;
use Aedart\Support\Helpers\Cache\CacheFactoryTrait;
use Aedart\Support\Helpers\Cache\CacheTrait;
use DateInterval;
use DateTimeInterface;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Acl Registrar
 *
 * @see \Aedart\Contracts\Acl\Registrar
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Acl
 */
class Registrar implements
    RegistrarInterface,
    ConfigAware,
    CacheFactoryAware
{
    use AclConfiguration;
    use CacheTrait;
    use CacheFactoryTrait;

    /**
     * Cache key
     *
     * @var string|null
     */
    protected string|null $key = null;

    /**
     * Cache ttl
     *
     * @var DateTimeInterface|DateInterval|int|null
     */
    protected DateTimeInterface|DateInterval|int|null $expires = null;

    /**
     * Obtained permissions
     *
     * @var Collection|Permission[]|null
     */
    protected Collection|array|null $permissions = null;

    /**
     * @inheritDoc
     */
    public function define(Gate $gate, bool $force = false): static
    {
        $permissions = $this->getPermissions($force);
        foreach ($permissions as $permission) {
            $this->defineAbility($gate, $permission);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getPermissions(bool $force = false)
    {
        if (isset($this->permissions) && !$force) {
            return $this->permissions;
        }

        if ($force) {
            $this->flush();
        }

        $key = $this->resolveKey();
        $ttl = $this->resolveTtl();

        return $this->permissions = $this->getCache()->remember($key, $ttl, function () {
            return $this->aclPermissionsModel()::with('roles')->get();
        });
    }

    /**
     * @inheritDoc
     */
    public function flush(): bool
    {
        $this->permissions = null;

        return $this->getCache()->forget($this->resolveKey());
    }

    /**
     * @inheritDoc
     */
    public function expires($ttl = null): static
    {
        $this->expires = $ttl;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function key(string|null $name = null): static
    {
        $this->key = $name;

        return $this;
    }

    /*****************************************************************
     * Defaults
     ****************************************************************/

    /**
     * @inheritdoc
     */
    public function getDefaultCache(): Repository|null
    {
        return $this->getCacheFactory()->store(
            $this->getConfig()->get('acl.cache.store')
        );
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Define ability (permission) for given access gate
     *
     * @param Gate $gate
     * @param  Model|Permission  $permission
     *
     * @return void
     */
    protected function defineAbility(Gate $gate, Model|Permission $permission): void
    {
        $gate->define($permission->getSlugKey(), function ($user) use ($permission) {
            /** @var Authenticatable|HasRoles $user */

            return $user->hasPermission($permission);
        });
    }

    /**
     * Returns specified cache key or defaults to key name from configuration
     *
     * @return string
     */
    protected function resolveKey(): string
    {
        return $this->key ?? $this->getConfig()->get('acl.cache.key', 'acl.permissions');
    }

    /**
     * returns the specified ttl or defaults to ttl from configuration
     *
     * @return DateInterval|DateTimeInterface|int|null
     */
    protected function resolveTtl(): DateInterval|DateTimeInterface|int|null
    {
        return $this->expires ?? $this->getConfig()->get('acl.cache.ttl', 60 * 60);
    }
}
