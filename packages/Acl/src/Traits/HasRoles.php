<?php

namespace Aedart\Acl\Traits;

use Aedart\Acl\Models\Concerns;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use InvalidArgumentException;

/**
 * Has Roles
 *
 * @property \Aedart\Acl\Models\Role[]|Collection $roles The roles assigned to this model
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
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
     * @see hasAllRoles
     *
     * @param string|int|\Aedart\Acl\Models\Role|Collection|string[]|int[]|\Aedart\Acl\Models\Role[] $roles Slugs, ids or Role instances or list of roles
     *
     * @return bool
     *
     * @throws InvalidArgumentException
     */
    public function hasRoles($roles): bool
    {
        /** @var Model|\Aedart\Acl\Models\Role $roleModel */
        $roleModel = $this->aclRoleModelInstance();

        // When a role's id is given
        if (is_numeric($roles)) {
            return $this->roles->contains($roleModel->getKeyName(), $roles);
        }

        // When a role's slug is given
        if (is_string($roles)) {
            return $this->roles->contains($roleModel->getSlugKeyName(), $roles);
        }

        // When a role instance is given
        $roleClass = $this->aclRoleModel();
        if ($roles instanceof $roleClass) {
            return $this->roles->contains($roleModel->getKeyName(), $roles->id);
        }

        // When a collection of roles is given
        if ($roles instanceof Collection) {
            return $roles->intersect($this->roles)->isNotEmpty();
        }

        // When an array of roles is given
        if (is_array($roles)) {
            return $this->hasAllRoles($roles);
        }

        // Unable to determine how to check given role, thus we must fail...
        throw new InvalidArgumentException(sprintf(
            'Unable to determine is given role(s) are assigned. Accepted values are slugs, ids, role instance or array. %s given',
            gettype($roles)
        ));
    }

    /**
     * Determine if model is assigned any (one of) of the given roles
     *
     * @param string[]|int[]|\Aedart\Acl\Models\Role[]|Collection $roles Slugs, ids or Role instances
     *
     * @return bool
     *
     * @throws InvalidArgumentException
     */
    public function hasAnyRoles($roles): bool
    {
        foreach ($roles as $role) {
            if ($this->hasRoles($role)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine if model is assigned all of the given roles
     *
     * Method will return false is any of given roles are not assigned
     * to this model.
     *
     * @param string[]|int[]|\Aedart\Acl\Models\Role[]|Collection $roles Slugs, ids or Role instances
     *
     * @return bool
     *
     * @throws InvalidArgumentException
     */
    public function hasAllRoles($roles): bool
    {
        foreach ($roles as $role) {
            if (!$this->hasRoles($role)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Assign given roles to this model
     *
     * @param string|int|\Aedart\Acl\Models\Role ...$roles
     *
     * @return self
     */
    public function assignRoles(...$roles)
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
     * @param string|int|\Aedart\Acl\Models\Role ...$roles
     *
     * @return self
     */
    public function syncRoles(...$roles)
    {
        return $this
            ->unassignAllRoles()
            ->assignRoles($roles);
    }

    /**
     * Unassign all given roles for this model
     *
     * @param string|int|\Aedart\Acl\Models\Role ...$roles
     *
     * @return self
     */
    public function unassignRoles(...$roles)
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
    public function unassignAllRoles()
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
     * @param \Aedart\Acl\Models\Permission $permission
     *
     * @return bool
     *
     * @throws InvalidArgumentException
     */
    public function hasPermission($permission): bool
    {
        $permissionClass = $this->aclPermissionsModel();
        if (!($permission instanceof $permissionClass)) {
            throw new InvalidArgumentException(sprintf('Permission must be instance of %s', $permissionClass));
        }

        return $this->hasRoles($permission->roles);
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
