<?php

namespace Aedart\Redmine\Partials;

/**
 * List Of Child Issue References
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Redmine\Partials
 */
class ListOfChildIssueReferences extends NestedList
{
    /**
     * @inheritDoc
     */
    public function itemType(): string
    {
        return ChildIssueReference::class;
    }
}
