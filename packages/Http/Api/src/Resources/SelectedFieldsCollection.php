<?php

namespace Aedart\Http\Api\Resources;

use Aedart\Contracts\Http\Api\SelectedFieldsCollection as SelectedFieldsCollectionInterface;

/**
 * Select Fields Collection
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Api\Resources
 */
class SelectedFieldsCollection implements SelectedFieldsCollectionInterface
{
    /**
     * Creates a new collection instance
     *
     * @param  string[]  $fields  [optional] List of fields to select
     */
    public function __construct(
        protected array $fields = []
    ) {
    }

    /**
     * @inheritDoc
     */
    public function has(string $field): bool
    {
        return in_array($field, $this->fields);
    }

    /**
     * @inheritdoc
     */
    public function isEmpty(): bool
    {
        return empty($this->fields);
    }

    /**
     * @inheritdoc
     */
    public function isNotEmpty(): bool
    {
        return !$this->isEmpty();
    }

    /**
     * @inheritDoc
     */
    public function count(): int
    {
        return count($this->fields);
    }

    /**
     * @inheritdoc
     */
    public function toArray(): array
    {
        return $this->fields;
    }

    /**
     * @inheritdoc
     */
    public function offsetExists(mixed $offset): bool
    {
        return isset($this->fields[$offset]);
    }

    /**
     * @inheritdoc
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->fields[$offset];
    }

    /**
     * @inheritdoc
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->fields[$offset] = $value;
    }

    /**
     * @inheritdoc
     */
    public function offsetUnset(mixed $offset): void
    {
        unset($this->fields[$offset]);
    }
}
