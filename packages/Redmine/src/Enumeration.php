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
 * @property int $id
 * @property string $name
 * @property bool $is_default
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Redmine
 */
abstract class Enumeration extends RedmineApiResource implements
    Listable
{
    protected array $allowed = [
        'id' => 'int',
        'name' => 'string',
        'is_default' => 'bool'
    ];

    /**
     * @inheritdoc
     */
    public function endpoint(...$params): string
    {
        return 'enumerations/' . parent::endpoint(...$params);
    }
}
