<?php

namespace Aedart\Redmine\Partials;

/**
 * List Of Role References
 *
 * @see RoleReference
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Redmine\Partials
 */
class ListOfRoleReferences extends NestedList
{
    /**
     * @inheritDoc
     */
    public function itemType(): string
    {
        return RoleReference::class;
    }
}
