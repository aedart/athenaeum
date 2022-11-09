<?php

namespace Aedart\Contracts\ETags;

use Aedart\Contracts\ETags\Exceptions\ETagException;
use ArrayAccess;
use Countable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use IteratorAggregate;
use JsonSerializable;
use Stringable;

/**
 * ETags Collection
 *
 * @implements ArrayAccess<int, ETag>
 * @implements IteratorAggregate<int, ETag>
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\ETags
 */
interface Collection extends
    ArrayAccess,
    Arrayable,
    Countable,
    IteratorAggregate,
    Jsonable,
    JsonSerializable,
    Stringable
{
    /**
     * Creates a new ETags Collection instance
     *
     * @param  ETag[]  $etags  [optional]
     *
     * @return static
     *
     * @throws ETagException
     */
    public static function make(array $etags = []): static;

    /**
     * Determine if Etag exists in this collection
     *
     * @see ETag::matches()
     *
     * @param  ETag|string  $eTag ETag instance or HTTP header value
     * @param  bool  $strongComparison  [optional] When true, two ETags are equivalent if
     *                                  both are NOT WEAK and their raw values match
     *                                  character-by-character.
     *                                  When false, two ETags are equivalent if their
     *                                  raw values match character-by-character, regardless
     *                                  of either or both being tagged as "weak"
     *
     * @return bool
     */
    public function contains(ETag|string $eTag, bool $strongComparison = false): bool;

    /**
     * Determine if Etag does not exist in this collection
     *
     * Opposite of {@see contains()}
     *
     * @param  ETag|string  $eTag ETag instance or HTTP header value
     * @param  bool  $strongComparison  [optional] When true, two ETags are equivalent if
     *                                  both are NOT WEAK and their raw values match
     *                                  character-by-character.
     *                                  When false, two ETags are equivalent if their
     *                                  raw values match character-by-character, regardless
     *                                  of either or both being tagged as "weak"
     *
     * @return bool
     */
    public function doesntContain(ETag|string $eTag, bool $strongComparison = false): bool;

    /**
     * Returns all etags in collection
     *
     * @return ETag[]
     */
    public function all(): array;

    /**
     * Returns string representation of this collection's Etags
     *
     * @return string
     */
    public function toString(): string;
}