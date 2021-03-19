<?php

namespace Aedart\Acl\Traits;

use Aedart\Support\Helpers\Config\ConfigTrait;
use Illuminate\Contracts\Auth\Authenticatable;

/**
 * Acl Components Trait
 *
 * Utility for obtaining various ACL components.
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Acl\Traits
 */
trait AclComponentsTrait
{
    use ConfigTrait;

    /**
     * In-memory Cache of acl models' class paths
     *
     * @var array key = identifier, value = class path
     */
    protected static array $aclModels = [];

    /**
     * In-memory Cache of acl table names
     *
     * @var array key = identifier, value = table name
     */
    protected static array $aclTables = [];

    /**
     * Returns the class path to the user eloquent model
     *
     * @return string
     */
    public function aclUserModel(): string
    {
        return $this->aclModel('user');
    }

    /**
     * Creates a new user eloquent model instance
     *
     * @return \Illuminate\Database\Eloquent\Model|Authenticatable
     */
    public function aclUserModelInstance()
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
     * @return string
     */
    public function aclRoleModel(): string
    {
        return $this->aclModel('role');
    }

    /**
     * Creates a new role eloquent model instance
     *
     * @return \Aedart\Acl\Models\Role
     */
    public function aclRoleModelInstance()
    {
        return $this->aclRoleModel()::make();
    }

    /**
     * Returns class path to permissions eloquent model
     *
     * @return string
     */
    public function aclPermissionsModel(): string
    {
        return $this->aclModel('permission');
    }

    /**
     * Creates a new permission eloquent model instance
     *
     * @return \Aedart\Acl\Models\Permission
     */
    public function aclPermissionsModelInstance()
    {
        return $this->aclPermissionsModel()::make();
    }

    /**
     * Returns class path to permission group eloquent model
     *
     * @return string
     */
    public function aclPermissionsGroupModel(): string
    {
        return $this->aclModel('group');
    }

    /**
     * Creates a new permission group eloquent model instance
     *
     * @return \Aedart\Acl\Models\Permissions\Group
     */
    public function aclPermissionsGroupModelInstance()
    {
        return $this->aclPermissionsGroupModel()::make();
    }

    /**
     * Returns the model class path that corresponds to given identifier
     *
     * @param string $identifier
     *
     * @return string|null
     */
    public function aclModel(string $identifier): ?string
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
    public function aclTable(string $identifier): ?string
    {
        if (isset(static::$aclTables[$identifier])) {
            return static::$aclTables[$identifier];
        }

        return static::$aclTables[$identifier] = $this->getConfig()->get("acl.tables.{$identifier}");
    }
}
