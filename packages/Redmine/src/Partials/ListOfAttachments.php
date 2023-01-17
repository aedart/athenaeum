<?php

namespace Aedart\Redmine\Partials;

use Aedart\Redmine\Attachment;

/**
 * List Of Attachments
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Redmine\Partials
 */
class ListOfAttachments extends NestedList
{
    /**
     * @inheritDoc
     */
    public function itemType(): string
    {
        return Attachment::class;
    }
}
