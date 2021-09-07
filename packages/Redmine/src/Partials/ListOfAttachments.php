<?php

namespace Aedart\Redmine\Partials;

use Aedart\Redmine\Attachment;

/**
 * List Of Attachments
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
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
