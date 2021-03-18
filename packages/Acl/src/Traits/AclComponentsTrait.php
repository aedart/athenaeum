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
     * Returns the database table name that corresponds to given identifier
     *
     * @param string $identifier
     *
     * @return string|null
     */
    protected function aclTable(string $identifier): ?string
    {
        return $this->getConfig()->get("acl.tables.{$identifier}");
    }
}