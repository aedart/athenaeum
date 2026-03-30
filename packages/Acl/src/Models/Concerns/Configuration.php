<?php

namespace Aedart\Acl\Models\Concerns;

use Aedart\Acl\Models\Permission;
use Aedart\Acl\Models\Permissions\Group as PermissionGroup;
use Aedart\Acl\Models\Role;
use Aedart\Support\Helpers\Config\ConfigTrait;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

/**
 * Concerns Acl Configuration
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Acl\Models\Concerns
 */
trait Configuration
{
    use ConfigTrait;

    /**
     * In-memory Cache of acl models' class paths
     *
     * @var array<string, class-string<Model>> key = identifier, value = class path
     */
    protected static array $aclModels = [];

    /**
     * In-memory Cache of acl table names
     *
     * @var array<string, string> key = identifier, value = table name
     */
    protected static array $aclTables = [];

    /**
     * Returns the class path to the user eloquent model
     *
     * @return class-string<Model & Authenticatable>
     */
    public function aclUserModel(): string
    {
        return $this->aclModel('user');
    }

    /**
     * Creates a new user eloquent model instance
     *
     * @return Model & Authenticatable
     */
    public function aclUserModelInstance(): Model & Authenticatable
    {
        // NOTE: We cannot rely on the "make()" method being available
        // for the user model. So we create a new instance the old
        // fashion way...
        $class = $this->aclUserModel();
        return new $class();
    }

    /**
     * Returns class path to role eloquent model
     *
     * @return class-string<Model|Role>
     */
    public function aclRoleModel(): string
    {
        return $this->aclModel('role');
    }

    /**
     * Creates a new role eloquent model instance
     *
     * @return Role|Model
     */
    public function aclRoleModelInstance(): Model|Role
    {
        return $this->aclRoleModel()::make();
    }

    /**
     * Returns class path to permissions eloquent model
     *
     * @return class-string<Model|Permission>
     */
    public function aclPermissionsModel(): string
    {
        return $this->aclModel('permission');
    }

    /**
     * Creates a new permission eloquent model instance
     *
     * @return Permission|Model
     */
    public function aclPermissionsModelInstance(): Model|Permission
    {
        return $this->aclPermissionsModel()::make();
    }

    /**
     * Returns class path to permission group eloquent model
     *
     * @return class-string<Model|PermissionGroup>
     */
    public function aclPermissionsGroupModel(): string
    {
        return $this->aclModel('group');
    }

    /**
     * Creates a new permission group eloquent model instance
     *
     * @return PermissionGroup|Model
     */
    public function aclPermissionsGroupModelInstance(): Model|PermissionGroup
    {
        return $this->aclPermissionsGroupModel()::make();
    }

    /**
     * Returns the model class path that corresponds to given identifier
     *
     * @param string $identifier
     *
     * @return class-string<Model>|null
     */
    public function aclModel(string $identifier): string|null
    {
        if (isset(static::$aclModels[$identifier])) {
            return static::$aclModels[$identifier];
        }

        return static::$aclModels[$identifier] = $this->getConfig()->get("acl.models.{$identifier}");
    }

    /**
     * Returns the database table name that corresponds to given identifier
     *
     * @param string $identifier
     *
     * @return string|null
     */
    public function aclTable(string $identifier): string|null
    {
        if (isset(static::$aclTables[$identifier])) {
            return static::$aclTables[$identifier];
        }

        return static::$aclTables[$identifier] = $this->getConfig()->get("acl.tables.{$identifier}");
    }
}
