<?php

namespace Aedart\Redmine\Partials;

/**
 * List Of Membership References
 *
 * @see MembershipReference
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Redmine\Partials
 */
class ListOfMembershipReferences extends NestedList
{
    /**
     * @inheritDoc
     */
    public function itemType(): string
    {
        return MembershipReference::class;
    }
}
