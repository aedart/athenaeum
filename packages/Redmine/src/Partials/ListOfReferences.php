<?php

namespace Aedart\Redmine\Partials;

use Aedart\Contracts\Utils\Populatable;
use Aedart\Utils\Json;
use ArrayIterator;
use Countable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use IteratorAggregate;
use JsonSerializable;

/**
 * List Of References
 *
 * @see \Aedart\Redmine\Partials\Reference
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Redmine\Partials
 */
class ListOfReferences extends NestedList {

    /**
     * @inheritDoc
     */
    public function itemType(): string
    {
        return Reference::class;
    }
}
