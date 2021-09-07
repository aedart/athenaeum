<?php

namespace Aedart\Redmine\Partials;

/**
 * List Of Custom Field References
 *
 * @see \Aedart\Redmine\Partials\CustomFieldReference
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Redmine\Partials
 */
class ListOfCustomFieldReferences extends NestedList
{
    /**
     * @inheritDoc
     */
    public function itemType(): string
    {
        return CustomFieldReference::class;
    }
}
