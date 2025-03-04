<?php

namespace Aedart\Streams\Meta;

use Aedart\Contracts\Streams\Meta\Repository as MetaRepositoryInterface;
use Illuminate\Support\Arr;

/**
 * Meta Repository
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Streams\Meta
 */
class Repository implements MetaRepositoryInterface
{
    /**
     * Creates new meta repository instance
     *
     * @param  array  $data  [optional] Meta-data items, Key-value pairs
     */
    public function __construct(
        protected array $data = []
    ) {
    }

    /**
     * @inheritDoc
     */
    public function populate(array $data = []): static
    {
        return $this->merge($data);
    }

    /**
     * @inheritDoc
     */
    public function set(string $key, mixed $value): static
    {
        Arr::set($this->data, $key, $value);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return Arr::get($this->data, $key, $default);
    }

    /**
     * @inheritDoc
     */
    public function has(string $key): bool
    {
        return Arr::has($this->data, $key);
    }

    /**
     * @inheritDoc
     */
    public function remove(string $key): bool
    {
        if ($this->has($key)) {
            Arr::forget($this->data, $key);

            return true;
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public function merge(array $meta): static
    {
        foreach ($meta as $key => $value) {
            $this->set($key, $value);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function all(): array
    {
        return Arr::undot($this->data);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return $this->all();
    }

    /**
     * @inheritDoc
     */
    public function offsetExists(mixed $offset): bool
    {
        return $this->has($offset);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->get($offset);
    }

    /**
     * @inheritDoc
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->set($offset, $value);
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset(mixed $offset): void
    {
        $this->remove($offset);
    }
}
