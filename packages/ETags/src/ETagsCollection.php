<?php

namespace Aedart\ETags;

use Aedart\Contracts\ETags\Collection;
use Aedart\Contracts\ETags\ETag;
use Aedart\ETags\Facades\Generator;
use Aedart\Utils\Json;
use ArrayIterator;
use JsonException;
use Traversable;

/**
 * ETagsCollection
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\ETags
 */
class ETagsCollection implements Collection
{
    /**
     * Creates new collection instance
     *
     * @param  ETag[]  $etags  [optional]
     */
    public function __construct(
        protected array $etags = []
    ) {}

    /**
     * @inheritDoc
     */
    public static function make(array $etags = []): static
    {
        return new static($etags);
    }

    /**
     * @inheritDoc
     */
    public function contains(ETag|string $eTag, bool $strongComparison = false): bool
    {
        // Convert to Etag instance, if not already. This should increase
        // the performance when matching.
        $eTag = $eTag instanceof ETag
            ? $eTag
            : Generator::parseSingle($eTag);

        // Match against each etag in collection
        foreach ($this->etags as $tag) {
            if ($tag->matches($eTag, $strongComparison)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public function doesntContain(ETag|string $eTag, bool $strongComparison = false): bool
    {
        return !$this->contains($eTag, $strongComparison);
    }

    /**
     * @inheritDoc
     */
    public function count(): int
    {
        return count($this->etags);
    }

    /**
     * @inheritDoc
     */
    public function isEmpty(): bool
    {
        return empty($this->etags);
    }

    /**
     * @inheritDoc
     */
    public function isNotEmpty(): bool
    {
        return !$this->isEmpty();
    }

    /**
     * @inheritDoc
     */
    public function all(): array
    {
        return $this->toArray();
    }

    /**
     * @inheritDoc
     *
     * @return Traversable<int, ETag>
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->etags);
    }

    /**
     * @inheritDoc
     *
     * @return ETag[]
     */
    public function toArray(): array
    {
        return $this->etags;
    }

    /**
     * @inheritDoc
     *
     * @throws JsonException
     */
    public function toJson($options = 0): string
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
    public function toString(): string
    {
        return implode(', ', array_map(fn(ETag $etag) => $etag->toString(), $this->etags));
    }

    /**
     * @inheritDoc
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * @inheritDoc
     */
    public function offsetExists(mixed $offset): bool
    {
        return isset($this->etags[$offset]);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet(mixed $offset): ETag
    {
        return $this->etags[$offset];
    }

    /**
     * @inheritDoc
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (is_null($offset)) {
            $this->etags[] = $value;
        } else {
            $this->etags[$offset] = $value;
        }
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset(mixed $offset): void
    {
        unset($this->etags[$offset]);
    }
}