<?php

namespace Aedart\Redmine\Partials\Journals;

use Aedart\Redmine\Partials\NestedList;

/**
 * List Of Journal Details
 *
 * @see Detail
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Redmine\Partials\Journals
 */
class ListOfDetails extends NestedList
{
    /**
     * @inheritDoc
     */
    public function itemType(): string
    {
        return Detail::class;
    }
}
