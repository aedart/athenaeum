<?php

namespace Aedart\Redmine\Partials;

use Aedart\Redmine\Relation;

/**
 * List Of Related Issues
 *
 * @see Relation
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Redmine\Partials
 */
class ListOfRelatedIssues extends NestedList
{
    /**
     * @inheritDoc
     */
    public function itemType(): string
    {
        return Relation::class;
    }
}
