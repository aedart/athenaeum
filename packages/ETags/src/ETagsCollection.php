<?php

namespace Aedart\ETags;

use Aedart\Contracts\ETags\Collection;
use Aedart\Contracts\ETags\ETag;
use Aedart\ETags\Exceptions\InvalidETagCollectionEntry;
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
     * The ETag entries of this collection
     *
     * @var ETag[]
     */
    protected array $etags = [];

    /**
     * Creates new collection instance
     *
     * @param  ETag[]  $etags  [optional]
     */
    public function __construct(array $etags = [])
    {
        // Add each given entry "manually", so that they can be resolved
        // and the wildcard etag vs. list of etags limitations are respected.
        // @see resolveEntry()

        foreach ($etags as $entry) {
            $this[] = $entry;
        }
    }

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
    public function jsonSerialize(): mixed
    {
        return array_map(
            fn (ETag $etag) => $etag->toString(),
            $this->all()
        );
    }

    /**
     * @inheritDoc
     */
    public function toString(): string
    {
        return implode(', ', array_map(fn (ETag $etag) => $etag->toString(), $this->etags));
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
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
            $this->etags[] = $this->resolveEntry($value);
        } else {
            // Unset existing offset, to avoid resolve issue
            unset($this[$offset]);

            // Replace (or rather add) entry
            $this->etags[$offset] = $this->resolveEntry($value);
        }
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset(mixed $offset): void
    {
        unset($this->etags[$offset]);
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Resolves given entry
     *
     * Method ensures that entry is a valid {@see ETag} instance, and that
     * it does not conflict with evt. already added etags (wildcard etag vs. list of etags)
     *
     * @param  mixed  $entry
     *
     * @return ETag
     *
     * @throws InvalidETagCollectionEntry
     */
    protected function resolveEntry(mixed $entry): ETag
    {
        if (!($entry instanceof ETag)) {
            throw new InvalidETagCollectionEntry(sprintf('Entry must be a valid ETag instead. Got %s instead', var_export($entry, true)));
        }

        // When collection is empty, to allow entry to be added...
        if ($this->isEmpty()) {
            return $entry;
        }

        // Acc. to RFS-9110:
        // [...] an If-Match / If-None-Match header field with a list value containing "*" and other values
        // (including other instances of "*") is syntactically invalid (therefore not allowed to be generated) [...]_
        //
        // Here, we ensure that this collection only contains a single wildcard etag or a list of regular etags.
        // @see https://httpwg.org/specs/rfc9110.html#field.if-match
        // @see https://httpwg.org/specs/rfc9110.html#field.if-none-match

        // Thus, when this collection isn't empty and a wildcard etag is given, we must fail.
        if ($entry->isWildcard()) {
            throw new InvalidETagCollectionEntry('Unable to add wildcard etag to existing list of etags');
        }

        // Alternatively, if this collection consists of a single wildcard entry, then must must
        // also fail...
        $index = array_key_first($this->etags);
        if ($this[$index]->isWildcard()) {
            throw new InvalidETagCollectionEntry('Collection contains a wildcard etag and unable to add more etags');
        }

        return $entry;
    }
}
