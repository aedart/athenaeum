<?php

namespace Aedart\Acl\Models;

use Aedart\Acl\Traits\AclComponentsTrait;
use Aedart\Contracts\Database\Models\Sluggable;
use Aedart\Database\Model;
use Aedart\Database\Models\Concerns;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

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
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Acl\Models
 */
class Role extends Model implements Sluggable
{
    use AclComponentsTrait;
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
     * Grant given permissions to this role
     *
     * @param string|int|\Aedart\Acl\Models\Permission ...$permissions Permission slugs, ids or Permission instances
     *
     * @return self
     */
    public function grantPermissions(...$permissions)
    {
        // TODO: Obtain permission ids

        //return $this->permissions()->withTimestamps()->save($permission);
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
        $this->permissions()->detach();

        return $this->grantPermissions($permissions);
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
        // $this->permissions()->detach($ids); // TODO: Obtain permissions ids

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
            $this->aclRoleModel(),
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