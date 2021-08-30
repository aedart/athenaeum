<?php

namespace Aedart\Redmine\Partials;

/**
 * List Of Journals
 *
 * @see Journal
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Redmine\Partials
 */
class ListOfJournals extends NestedList
{
    /**
     * @inheritDoc
     */
    public function itemType(): string
    {
        return Journal::class;
    }
}
