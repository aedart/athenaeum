<?php

namespace Aedart\Acl\Traits;

use Aedart\Acl\Models\Concerns;
use Aedart\Acl\Models\Permission;
use Aedart\Acl\Models\Role;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use InvalidArgumentException;

/**
 * Has Roles
 *
 * @property Role[]|Collection $roles The roles assigned to this model
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Acl\Traits
 */
trait HasRoles
{
    use Concerns\AclModels;

    /*****************************************************************
     * Operations
     ****************************************************************/

    /**
     * Determine if model is assigned given role
     *
     * If an array of roles is given, then method will return true,
     * ONLY if all roles are assigned to this model!
     *
     * @param Role|int|string|Model|Model[]|Role[]|Collection|int[]|string[] $roles Slugs, ids or Role instances or list of roles
     *
     * @return bool
     *
     * @throws InvalidArgumentException
     *@see hasAllRoles
     *
     */
    public function hasRoles(array|Collection|Role|Model|int|string $roles): bool
    {
        return $this->hasRelatedModels(
            $roles,
            $this->aclRoleModelInstance(),
            'roles'
        );
    }

    /**
     * Determine if model is assigned any (one of) of the given roles
     *
     * @param  Collection|int[]|Model[]|Role[]|string[]  $roles Slugs, ids or collection or Role instances
     *
     * @return bool
     *
     * @throws InvalidArgumentException
     */
    public function hasAnyRoles(array|Collection $roles): bool
    {
        return $this->hasAnyOf($roles, $this->aclRoleModelInstance(), 'roles');
    }

    /**
     * Determine if model is assigned all given roles
     *
     * Method will return false is any of given roles are not assigned
     * to this model.
     *
     * @param  Collection|int[]|Model[]|Role[]|string[]  $roles Slugs, ids or collection or Role instances
     *
     * @return bool
     *
     * @throws InvalidArgumentException
     */
    public function hasAllRoles(array|Collection $roles): bool
    {
        return $this->hasAllOf($roles, $this->aclRoleModelInstance(), 'roles');
    }

    /**
     * Assign given roles to this model
     *
     * @param string|int|Role ...$roles
     *
     * @return self
     */
    public function assignRoles(...$roles): static
    {
        $ids = $this->obtainModelIds($this->aclRoleModelInstance(), $roles);

        $this
            ->roles()
            ->withTimestamps()
            ->sync($ids, false);

        return $this;
    }

    /**
     * Revokes all existing permissions and grants given permissions
     * to this role
     *
     * @param string|int|Role ...$roles
     *
     * @return self
     */
    public function syncRoles(...$roles): static
    {
        return $this
            ->unassignAllRoles()
            ->assignRoles(...$roles);
    }

    /**
     * Unassign all given roles for this model
     *
     * @param string|int|Role ...$roles
     *
     * @return self
     */
    public function unassignRoles(...$roles): static
    {
        $ids = $this->obtainModelIds($this->aclRoleModelInstance(), $roles);

        $this->roles()->detach($ids);

        return $this;
    }

    /**
     * Revokes all roles for this model
     *
     * @return self
     */
    public function unassignAllRoles(): static
    {
        $this->roles()->detach();

        return $this;
    }

    /**
     * Determine if this model is granted given permission
     *
     * Method searches throughout this model's assigned roles and
     * determines if given permission's roles is among them.
     *
     * @param  Model|Permission  $permission
     *
     * @return bool
     *
     * @throws InvalidArgumentException
     */
    public function hasPermission(Model|Permission $permission): bool
    {
        $permissionClass = $this->aclPermissionsModel();
        if (!($permission instanceof $permissionClass)) {
            throw new InvalidArgumentException(sprintf('Permission must be instance of %s', $permissionClass));
        }

        return $this->hasAnyRoles($permission->roles);
    }

    /*****************************************************************
     * Relations
     ****************************************************************/

    /**
     * The roles that are assigned to this model
     *
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        $role = $this->aclRoleModelInstance();

        return $this->belongsToMany(
            $this->aclRoleModel(),
            $this->aclTable('users_roles'),
            $this->getForeignKey(),
            $role->getForeignKey()
        );
    }
}
