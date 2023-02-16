<?php

namespace Aedart\Redmine\Partials;

/**
 * List Of Changesets
 *
 * @see Changeset
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Redmine\Partials
 */
class ListOfChangesets extends NestedList
{
    /**
     * @inheritDoc
     */
    public function itemType(): string
    {
        return Changeset::class;
    }
}
