<?php

namespace Aedart\Redmine;

use Aedart\Contracts\Redmine\Listable;

/**
 * Enumeration Resource
 *
 * Base class for enumeration resources
 *
 * @see https://www.redmine.org/projects/redmine/wiki/Rest_Enumerations
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Redmine
 */
abstract class Enumeration extends RedmineResource implements
    Listable
{
    /**
     * @inheritdoc
     */
    public function endpoint(...$params): string
    {
        return 'enumerations/' . parent::endpoint(...$params);
    }
}
