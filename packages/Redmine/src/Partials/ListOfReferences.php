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
class ListOfReferences implements Populatable,
    Arrayable,
    IteratorAggregate,
    Countable,
    Jsonable,
    JsonSerializable
{
    /**
     * Actual list of references
     *
     * @var Reference[]
     */
    protected array $references = [];

    /**
     * ListOfReferences
     *
     * @param array|Reference[] $references
     */
    public function __construct(array $references = [])
    {
        $this->populate($references);
    }

    /**
     * @inheritDoc
     */
    public function populate(array $data = []): void
    {
        $this->references = array_map(function($reference) {
            if ($reference instanceof Reference) {
                return $reference;
            }

            return Reference::makeNew($reference);
        }, $data);
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        return new ArrayIterator($this->references);
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return $this->references;
    }

    /**
     * @inheritDoc
     */
    public function toJson($options = 0)
    {
        return Json::encode($this->jsonSerialize(), $options);
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * @inheritDoc
     */
    public function count()
    {
        return count($this->references);
    }
}