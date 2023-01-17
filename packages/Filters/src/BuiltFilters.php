<?php

namespace Aedart\Filters;

use Aedart\Contracts\Database\Query\Criteria;
use Aedart\Contracts\Filters\BuiltFiltersMap;
use Aedart\Utils\Arr;

/**
 * Built Filters Map
 *
 * @see \Aedart\Contracts\Filters\BuiltFiltersMap
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Filters
 */
class BuiltFilters implements BuiltFiltersMap
{
    /**
     * Map of built filters, and other data
     *
     * @var array Key-value store
     */
    protected array $map = [];

    /**
     * Arbitrary meta data
     *
     * @var array Key-value store
     */
    protected array $meta = [];

    /**
     * BuiltFilters
     *
     * @param array $filters [optional]
     * @param array $meta [optional]
     */
    public function __construct(array $filters = [], array $meta = [])
    {
        $this->map = $filters;
        $this->meta = $meta;
    }

    /**
     * @inheritDoc
     */
    public function add(string $key, Criteria $filter): static
    {
        if (!isset($this->map[$key])) {
            $this->map[$key] = [];
        }

        $entry = $this->map[$key];
        $entry[] = $filter;

        $this->map[$key] = $entry;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function get(string $key, array $default = []): array
    {
        if (isset($this->map[$key])) {
            return $this->map[$key];
        }

        return $default;
    }

    /**
     * @inheritDoc
     */
    public function has(string $key): bool
    {
        return isset($this->map[$key]);
    }

    /**
     * @inheritDoc
     */
    public function forget(string $key): static
    {
        unset($this->map[$key]);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function all(): array
    {
        return Arr::flatten($this->map);
    }

    /**
     * @inheritDoc
     */
    public function setMeta(string $key, mixed $meta): static
    {
        $this->meta[$key] = $meta;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getMeta(string $key, mixed $default = null): mixed
    {
        if (isset($this->meta[$key])) {
            return $this->meta[$key];
        }

        return $default;
    }

    /**
     * @inheritDoc
     */
    public function hasMeta(string $key): bool
    {
        return isset($this->meta[$key]);
    }

    /**
     * @inheritDoc
     */
    public function forgetMeta(string $key): static
    {
        unset($this->meta[$key]);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function meta(): array
    {
        return $this->meta;
    }

    /**
     * @inheritDoc
     */
    public function forgetAll(): static
    {
        $this->map = [];
        $this->meta = [];

        return $this;
    }
}
