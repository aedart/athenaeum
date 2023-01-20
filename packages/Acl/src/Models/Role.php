<?php

namespace Aedart\Acl\Models;

use Aedart\Acl\Models\Concerns as AclConcerns;
use Aedart\Contracts\Database\Models\Sluggable;
use Aedart\Database\Model;
use Aedart\Database\Models\Concerns;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
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
 * @property Permission[]|Collection $permissions Permissions that are granted to this role
 * @property BaseModel|Authenticatable $users Users that have this role are assigned to them
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
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
     * ONLY if all permissions are granted!
     *
     * @see hasAllPermissions
     *
     * @param int|string|Collection|BaseModel|BaseModel[]|int[]|Role|Role[]|string[]  $permissions Slugs, ids or Permission instances or list of roles
     *
     * @return bool
     *
     * @throws InvalidArgumentException
     */
    public function hasPermission(array|Collection|BaseModel|Role|int|string $permissions): bool
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
     * @param  BaseModel[]|Collection|int[]|Permission[]|string[]  $permissions Slugs, ids or collection or Permission instances
     *
     * @return bool
     *
     * @throws InvalidArgumentException
     */
    public function hasAnyPermissions(array|Collection $permissions): bool
    {
        return $this->hasAnyOf($permissions, $this->aclPermissionsModelInstance(), 'permissions');
    }

    /**
     * Determine if role is granted the given permissions
     *
     * Method will return false is any of given permissions are not granted
     * to this role
     *
     * @param  BaseModel[]|Collection|int[]|Permission[]|string[]  $permissions Slugs, ids or collection or Permission instances
     *
     * @return bool
     *
     * @throws InvalidArgumentException
     */
    public function hasAllPermissions(array|Collection $permissions): bool
    {
        return $this->hasAllOf($permissions, $this->aclPermissionsModelInstance(), 'permissions');
    }

    /**
     * Grant given permissions to this role
     *
     * @param string|int|Permission  ...$permissions Permission slugs, ids or Permission instances
     *
     * @return self
     */
    public function grantPermissions(...$permissions): static
    {
        $ids = $this->obtainModelIds($this->aclPermissionsModelInstance(), ...$permissions);

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
     * @param string|int|Permission  ...$permissions Permission slugs, ids or Permission instances
     *
     * @return self
     */
    public function syncPermissions(...$permissions): static
    {
        return $this
            ->revokeAllPermissions()
            ->grantPermissions(...$permissions);
    }

    /**
     * Revoke all given permissions
     *
     * @param string|int|Permission  ...$permissions Permission slugs, ids or Permission instances
     *
     * @return self
     */
    public function revokePermissions(...$permissions): static
    {
        $ids = $this->obtainModelIds($this->aclPermissionsModelInstance(), ...$permissions);

        $this->permissions()->detach($ids);

        return $this;
    }

    /**
     * Revokes all permissions for this role
     *
     * @return self
     */
    public function revokeAllPermissions(): static
    {
        $this->permissions()->detach();

        return $this;
    }

    /**
     * Create a new role and grant it the given permissions
     *
     * @param array $attributes
     * @param string|int|Permission  ...$permissions Permission slugs, ids or Permission instances
     * @return static
     *
     * @throws Throwable
     */
    public static function createWithPermissions(array $attributes, ...$permissions): static
    {
        return (new static())->getConnection()->transaction(function () use ($attributes, $permissions) {
            /** @var static $role */
            return static::create($attributes)
                    ->grantPermissions($permissions);
        });
    }

    /**
     * Update this role and grant given permissions
     *
     * @see updateWithPermissions
     *
     * @param array $attributes
     * @param string|int|Permission ...$permissions Permission slugs, ids or Permission instances
     *
     * @return bool
     *
     * @throws Throwable
     */
    public function updateAndGrantPermissions(array $attributes, ...$permissions): bool
    {
        return $this->updateWithPermissions($attributes, false, ...$permissions);
    }

    /**
     * Update this role and sync given permissions
     *
     * @see updateWithPermissions
     *
     * @param array $attributes
     * @param string|int|Permission ...$permissions Permission slugs, ids or Permission instances
     *
     * @return bool
     *
     * @throws Throwable
     */
    public function updateAndSyncPermissions(array $attributes, ...$permissions): bool
    {
        return $this->updateWithPermissions($attributes, true, ...$permissions);
    }

    /**
     * Update this role, grant or sync the given permissions
     *
     * @see grantPermissions
     * @see syncPermissions
     *
     * @param array $attributes
     * @param bool $sync If true, then permissions are synced. If false, then given permissions are attempted granted.
     * @param string|int|Permission ...$permissions Permission slugs, ids or Permission instances
     *
     * @return bool
     *
     * @throws Throwable
     */
    public function updateWithPermissions(array $attributes, bool $sync, ...$permissions): bool
    {
        return $this->getConnection()->transaction(function () use ($attributes, $sync, $permissions) {
            $saved = $this
                ->fill($attributes)
                ->save();

            if ($sync) {
                $this->syncPermissions(...$permissions);
            } else {
                $this->grantPermissions(...$permissions);
            }

            return $saved;
        });
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
