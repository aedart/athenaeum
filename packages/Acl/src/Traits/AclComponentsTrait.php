<?php

namespace Aedart\Acl\Traits;

use Aedart\Support\Helpers\Config\ConfigTrait;

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
     * Returns class path to permissions model
     *
     * @return string
     */
    public function aclPermissionsModel(): string
    {
        return $this->aclModel('permission');
    }

    /**
     * Returns class path to permission group model
     *
     * @return string
     */
    public function aclPermissionsGroupModel(): string
    {
        return $this->aclModel('group');
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
        return $this->getConfig()->get("acl.models.{$identifier}");
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
        return $this->getConfig()->get("acl.tables.{$identifier}");
    }
}