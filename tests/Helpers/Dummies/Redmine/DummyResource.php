<?php

namespace Aedart\Tests\Helpers\Dummies\Redmine;

use Aedart\Contracts\Redmine\Creatable;
use Aedart\Contracts\Redmine\Deletable;
use Aedart\Contracts\Redmine\Listable;
use Aedart\Contracts\Redmine\Updatable;
use Aedart\Redmine\RedmineResource;

/**
 * Dummy Resource
 *
 * FOR TESTING PURPOSES ONLY
 *
 * @property int|null $id
 * @property string|null $name
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\Helpers\Dummies\Redmine
 */
class DummyResource extends RedmineResource implements
    Listable,
    Creatable,
    Updatable,
    Deletable
{
    protected array $allowed = [
        'id' => 'int',
        'name' => 'string'
    ];

    /**
     * @inheritDoc
     */
    public function resourceName(): string
    {
        return 'dummies';
    }
}
