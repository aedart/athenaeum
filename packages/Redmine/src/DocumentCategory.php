<?php

namespace Aedart\Redmine;

/**
 * Document Category (Enumeration)
 *
 * @see https://www.redmine.org/projects/redmine/wiki/Rest_Enumerations
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Redmine
 */
class DocumentCategory extends Enumeration
{
    /**
     * @inheritDoc
     */
    public function resourceName(): string
    {
        return 'document_categories';
    }
}
