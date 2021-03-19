<?php

namespace Aedart\Acl\Models;

use Aedart\Acl\Traits\AclTrait;
use Aedart\Contracts\Database\Models\Sluggable;
use Aedart\Database\Model;
use Aedart\Database\Models\Concerns;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use InvalidArgumentException;

/**
 * Role
 *
 * @property int $id Unique identifier
 * @property string $slug Unique string identifier
 * @property string $name Name of role
 * @property string|null $description Evt. description of role
 * @property Carbon $created_at Date and time of when record was created
 * @property Carbon $updated_at Date and time of when record was last updated
 * @property Carbon|null $deleted_at Evt. date and time of when record was soft-deleted
 *
 * @property \Aedart\Acl\Models\Permission[]|Collection $permissions Permissions that are granted to this role
 * @property \Illuminate\Database\Eloquent\Model|Authenticatable $users Users that have this role are assigned to them
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Acl\Models
 */
class Role extends Model implements Sluggable
{
    use AclTrait;
    use SoftDeletes;
    use Concerns\Slugs;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var string[]|bool
     */
    protected $guarded = ['id'];

    /**
     * @inheritdoc
     */
    public function __construct(array $attributes = [])
    {
        $this->table = $this->aclTable('roles');

        parent::__construct($attributes);
    }

    /*****************************************************************
     * Operations
     ****************************************************************/

    /**
     * Determine if role has given permission(s) granted
     *
     * If an array of permissions is given, then method will return true,
     * ONLY if all of the permissions are granted!
     *
     * @see hasAllPermissions
     *
     * @param string|int|\Aedart\Acl\Models\Role|Collection|string[]|int[]|\Aedart\Acl\Models\Role[] $permissions Slugs, ids or Permission instances or list of roles
     *
     * @return bool
     *
     * @throws InvalidArgumentException
     */
    public function hasPermission($permissions): bool
    {
        /** @var \Illuminate\Database\Eloquent\Model|\Aedart\Acl\Models\Permission $permissionModel */
        $permissionModel = $this->aclPermissionsModelInstance();

        // When a permission's id is given
        if (is_numeric($permissions)) {
            return $this->permissions->contains($permissionModel->getKeyName(), $permissions);
        }

        // When a permission's slug is given
        if (is_string($permissions)) {
            return $this->permissions->contains($permissionModel->getSlugKeyName(), $permissions);
        }

        // When a permission instance is given
        $permissionClass = $this->aclPermissionsModel();
        if ($permissions instanceof $permissionClass) {
            return $this->permissions->contains($permissionModel->getKeyName(), $permissions->id);
        }

        // When a collection of permissions is given
        if ($permissions instanceof Collection) {
            return $permissions->intersect($this->permissions)->isNotEmpty();
        }

        // When an array of permissions is given
        if (is_array($permissions)) {
            return $this->hasAllPermissions($permissions);
        }

        // Unable to determine how to check given permission, thus we must fail...
        throw new InvalidArgumentException(sprintf(
            'Unable to determine is given permission(s) are granted. Accepted values are slugs, ids, permission instance or array. %s given',
            gettype($permissions)
        ));
    }

    /**
     * Determine if role has any of given permissions granted
     *
     * @param string[]|int[]|\Aedart\Acl\Models\Permission[]|Collection $permissions Slugs, ids or Permission instances
     *
     * @return bool
     *
     * @throws InvalidArgumentException
     */
    public function hasAnyPermissions($permissions): bool
    {
        foreach ($permissions as $permission) {
            if ($this->hasPermission($permission)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine if role is granted the given permissions
     *
     * Method will return false is any of given permissions are not granted
     * to this role
     *
     * @param string[]|int[]|\Aedart\Acl\Models\Permission[]|Collection $permissions Slugs, ids or Permission instances
     *
     * @return bool
     *
     * @throws InvalidArgumentException
     */
    public function hasAllPermissions($permissions): bool
    {
        foreach ($permissions as $role) {
            if (!$this->hasPermission($role)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Grant given permissions to this role
     *
     * @param string|int|\Aedart\Acl\Models\Permission ...$permissions Permission slugs, ids or Permission instances
     *
     * @return self
     */
    public function grantPermissions(...$permissions)
    {
        $ids = $this->obtainPermissionIds($permissions);

        $this
            ->permissions()
            ->withTimestamps()
            ->sync($ids, false);

        return $this;
    }

    /**
     * Revokes all existing permissions and grants given permissions
     * to this role
     *
     * @param string|int|\Aedart\Acl\Models\Permission ...$permissions Permission slugs, ids or Permission instances
     *
     * @return self
     */
    public function syncPermissions(...$permissions)
    {
        return $this
            ->revokeAllPermissions()
            ->grantPermissions($permissions);
    }

    /**
     * Revoke all given permissions
     *
     * @param string|int|\Aedart\Acl\Models\Permission ...$permissions Permission slugs, ids or Permission instances
     *
     * @return self
     */
    public function revokePermissions(...$permissions)
    {
        $ids = $this->obtainPermissionIds($permissions);

        $this->permissions()->detach($ids);

        return $this;
    }

    /**
     * Revokes all permissions for this role
     *
     * @return self
     */
    public function revokeAllPermissions()
    {
        $this->permissions()->detach();

        return $this;
    }

    /*****************************************************************
     * Relations
     ****************************************************************/

    /**
     * Permissions that are granted to this role
     *
     * @return BelongsToMany
     */
    public function permissions(): BelongsToMany
    {
        $permission = $this->aclPermissionsModelInstance();

        return $this->belongsToMany(
            $this->aclPermissionsModel(),
            $this->aclTable('roles_permissions'),
            $this->getForeignKey(),
            $permission->getForeignKey()
        );
    }

    /**
     * Users that have this role are assigned to them
     *
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        $user = $this->aclUserModelInstance();

        return $this->belongsToMany(
            $this->aclUserModel(),
            $this->aclTable('users_roles'),
            $this->getForeignKey(),
            $user->getForeignKey()
        );
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Obtains ids for given permissions
     *
     * @param mixed ...$permissions
     *
     * @return int[]
     */
    protected function obtainPermissionIds(...$permissions): array
    {
        return collect($permissions)
            ->flatten()
            ->map(function($permission) {
                return $this->resolveOrFindPermissions($permission);
            })
            ->map->id
            ->all();
    }

    /**
     * Resolves or finds given permissions
     *
     * @param string|int|\Aedart\Acl\Models\Permission|string[]|int[]|\Aedart\Acl\Models\Permission[]|Collection $permissions
     *
     * @return Collection|\Aedart\Acl\Models\Permission[]]
     */
    protected function resolveOrFindPermissions($permissions)
    {
        $permissionClass = $this->aclPermissionsModel();
        if ($permissions instanceof $permissionClass) {
            return $permissions;
        }

        // When id is given
        if (is_numeric($permissions)) {
            return $permissionClass::find($permissions);
        }

        // When slug is given
        if (is_string($permissions)) {
            return $permissionClass::findBySlug($permissions);
        }

        // When a collection of permissions is given
        if ($permissions instanceof Collection) {
            // Ensure all instances are of type permission
            return $permissions->filter(function($permission) use ($permissionClass) {
                return $permission instanceof $permissionClass;
            });
        }

        // When an array of permissions is given...
        if (is_array($permissions)) {
            $model = $this->aclPermissionsModelInstance();

            return $model
                ->newQuery()
                ->whereSlugIn($permissions)
                ->orWhereIn($model->getKeyName(), $permissions)
                ->get();
        }

        // Unable to resolve
        throw new InvalidArgumentException(sprintf(
            'Unable to resolve or find requested permissions. Accepted values are slugs, ids or permission instances. %s given',
            gettype($permissions)
        ));
    }
}