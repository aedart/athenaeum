<?php

namespace Aedart\Acl\Models;

use Aedart\Acl\Models\Concerns as AclConcerns;
use Aedart\Contracts\Database\Models\Sluggable;
use Aedart\Database\Model;
use Aedart\Database\Models\Concerns;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use Throwable;

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
    use SoftDeletes;
    use AclConcerns\AclModels;
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
        return $this->hasRelatedModels(
            $permissions,
            $this->aclPermissionsModelInstance(),
            'permissions'
        );
    }

    /**
     * Determine if role has any of given permissions granted
     *
     * @param string[]|int[]|\Aedart\Acl\Models\Permission[]|Collection $permissions Slugs, ids or collection or Permission instances
     *
     * @return bool
     *
     * @throws InvalidArgumentException
     */
    public function hasAnyPermissions($permissions): bool
    {
        return $this->hasAnyOf($permissions, $this->aclPermissionsModelInstance(), 'permissions');
    }

    /**
     * Determine if role is granted the given permissions
     *
     * Method will return false is any of given permissions are not granted
     * to this role
     *
     * @param string[]|int[]|\Aedart\Acl\Models\Permission[]|Collection $permissions Slugs, ids or collection or Permission instances
     *
     * @return bool
     *
     * @throws InvalidArgumentException
     */
    public function hasAllPermissions($permissions): bool
    {
        return $this->hasAllOf($permissions, $this->aclPermissionsModelInstance(), 'permissions');
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
        $ids = $this->obtainModelIds($this->aclPermissionsModelInstance(), $permissions);

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
        $ids = $this->obtainModelIds($this->aclPermissionsModelInstance(), $permissions);

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

    /**
     * Create a new role and grant it the given permissions
     *
     * @param array $attributes
     * @param string|int|\Aedart\Acl\Models\Permission ...$permissions Permission slugs, ids or Permission instances
     * @return static
     *
     * @throws Throwable
     */
    public static function createWithPermissions(array $attributes, ...$permissions)
    {
        DB::beginTransaction();
        try {
            // First, we create the role with given data and thereafter
            // grant all given permissions.

            /** @var static $role */
            $role = static::create($attributes);

            return $role->grantPermissions($permissions);
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Update this role and grant given permissions
     *
     * @see updateWithPermissions
     *
     * @param array $attributes
     * @param string|int|\Aedart\Acl\Models\Permission ...$permissions Permission slugs, ids or Permission instances
     *
     * @return bool
     *
     * @throws Throwable
     */
    public function updateAndGrantPermissions(array $attributes, ...$permissions): bool
    {
        return $this->updateWithPermissions($attributes, false, $permissions);
    }

    /**
     * Update this role and sync given permissions
     *
     * @see updateWithPermissions
     *
     * @param array $attributes
     * @param string|int|\Aedart\Acl\Models\Permission ...$permissions Permission slugs, ids or Permission instances
     *
     * @return bool
     *
     * @throws Throwable
     */
    public function updateAndSyncPermissions(array $attributes, ...$permissions): bool
    {
        return $this->updateWithPermissions($attributes, true, $permissions);
    }

    /**
     * Update this role, grant or sync the given permissions
     *
     * @see syncPermissions
     * @see grantPermissions
     *
     * @param array $attributes
     * @param bool $sync If true, then permissions are synced. If false, then given permissions are attempted granted.
     * @param string|int|\Aedart\Acl\Models\Permission ...$permissions Permission slugs, ids or Permission instances
     *
     * @return bool
     *
     * @throws Throwable
     */
    public function updateWithPermissions(array $attributes, bool $sync, ...$permissions): bool
    {
        DB::beginTransaction();
        try {
            // Similar to the custom create method, we first update the role
            // and thereafter either grant or sync the given permissions

            $saved = $this
                ->fill($attributes)
                ->save();

            if ($sync) {
                $this->syncPermissions($permissions);
                return $saved;
            }

            $this->grantPermissions($permissions);
            return $saved;
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
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
}
