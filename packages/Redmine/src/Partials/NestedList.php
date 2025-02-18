<?php

namespace Aedart\Redmine\Partials;

use Aedart\Contracts\Redmine\Connection;
use Aedart\Contracts\Redmine\ConnectionAware;
use Aedart\Contracts\Utils\Populatable;
use Aedart\Dto\ArrayDto;
use Aedart\Redmine\Traits\ConnectionTrait;
use Aedart\Utils\Json;
use ArrayAccess;
use ArrayIterator;
use Countable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use IteratorAggregate;
use JsonSerializable;
use Traversable;

/**
 * Base List
 *
 * Base abstraction for "nested lists", containing some kind of partial DTO.
 *
 * @template T
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Redmine\Partials
 */
abstract class NestedList implements
    ConnectionAware,
    Populatable,
    Arrayable,
    IteratorAggregate,
    ArrayAccess,
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
    public function populate(array $data = []): static
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

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setConnection(Connection|null $connection): static
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
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->list);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return $this->list;
    }

    /**
     * @inheritDoc
     */
    public function toJson($options = 0): string
    {
        return Json::encode($this->jsonSerialize(), $options);
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }

    /**
     * @inheritDoc
     */
    public function count(): int
    {
        return count($this->list);
    }

    /**
     * @inheritDoc
     */
    public function offsetExists(mixed $offset): bool
    {
        return isset($this->list[$offset]);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->list[$offset];
    }

    /**
     * @inheritDoc
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->list[$offset] = $value;
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset(mixed $offset): void
    {
        unset($this->list[$offset]);
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
