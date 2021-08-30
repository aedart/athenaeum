<?php

namespace Aedart\Redmine\Partials;

use Aedart\Contracts\Redmine\Connection;
use Aedart\Contracts\Redmine\ConnectionAware;
use Aedart\Contracts\Utils\Populatable;
use Aedart\Dto\ArrayDto;
use Aedart\Redmine\Traits\ConnectionTrait;
use Aedart\Utils\Json;
use ArrayIterator;
use Countable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use IteratorAggregate;
use JsonSerializable;

/**
 * Base List
 *
 * Base abstraction for "nested lists", containing some kind of partial DTO.
 *
 * @template T
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Redmine\Partials
 */
abstract class NestedList implements
    ConnectionAware,
    Populatable,
    Arrayable,
    IteratorAggregate,
    Countable,
    Jsonable,
    JsonSerializable
{
    use ConnectionTrait {
        setConnection as traitSetConnection;
    }

    /**
     * Actual list of nested DTOs
     *
     * @var array<T>
     */
    protected array $list = [];

    /**
     * ListOfReferences
     *
     * @param array<T> $items
     */
    public function __construct(array $items = [])
    {
        $this->populate($items);
    }

    /**
     * Returns the type of item this list contains
     *
     * @return string Class path to some kind of partial DTO
     */
    abstract public function itemType(): string;

    /**
     * @inheritDoc
     */
    public function populate(array $data = []): void
    {
        $this->list = array_map(function ($reference) {
            /** @var ArrayDto $type */
            $type = $this->itemType();

            if ($reference instanceof $type) {
                return $reference;
            }

            $nested = $type::makeNew($reference);

            // Set connection, if nested DTO expects one
            return $this->resolveItemConnection($nested);
        }, $data);
    }

    /**
     * @inheritdoc
     */
    public function setConnection(?Connection $connection)
    {
        $this->traitSetConnection($connection);

        // Apply new connection on all items that require it
        foreach ($this->list as $item) {
            $this->resolveItemConnection($item);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        return new ArrayIterator($this->list);
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return $this->list;
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
        return count($this->list);
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Resolves connection for item
     *
     * @param T $item
     *
     * @return T|ConnectionAware
     */
    protected function resolveItemConnection($item)
    {
        if ($item instanceof ConnectionAware) {
            $item->setConnection($this->getConnection());
        }

        return $item;
    }
}
