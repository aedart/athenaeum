<?php

namespace Aedart\ETags;

use Aedart\Contracts\ETags\Collection;
use Aedart\Contracts\ETags\ETag as ETagInterface;
use Aedart\ETags\Exceptions\InvalidRawValue;
use Aedart\ETags\Exceptions\UnableToParseETag;
use Aedart\Support\Facades\IoCFacade;

/**
 * ETag
 *
 * @see \Aedart\Contracts\ETags\ETag
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\ETags
 */
class ETag implements ETagInterface
{
    /**
     * Special case, when raw value set to '*' (wildcard)
     *
     * @var bool
     */
    protected bool $isWildcard = false;

    /**
     * Creates a new ETag instance
     *
     * @param  string  $rawValue
     * @param  bool  $isWeak  [optional]
     */
    public function __construct(
        protected string $rawValue,
        protected bool $isWeak = false
    ) {
        if (empty($this->rawValue)) {
            throw new InvalidRawValue('Cannot create ETag for empty string value');
        }

        $this->isWildcard = ($this->rawValue === static::WILDCARD_SYMBOL);
    }

    /**
     * @inheritDoc
     */
    public static function make(string $rawValue, bool $isWeak = false): static
    {
        return new static($rawValue, $isWeak);
    }

    /**
     * @inheritDoc
     */
    public static function parse(string $rawHeaderValue): Collection
    {
        $values = preg_split('/\s*,\s*/', $rawHeaderValue, -1, PREG_SPLIT_NO_EMPTY);

        $etags = array_map(
            fn ($value) => static::parseSingle($value),
            $values
        );

        return IoCFacade::tryMake(
            abstract: Collection::class,
            default: fn () => ETagsCollection::make($etags),
            parameters: $etags
        );
    }

    /**
     * @inheritDoc
     */
    public static function parseSingle(string $value): static
    {
        if (str_contains($value, ',')) {
            throw new UnableToParseETag(sprintf('Unable to parse multiple etags from: %s', $value));
        }

        $isWeak = str_starts_with($value, static::WEAK_INDICATOR);
        $raw = static::extractRawValue($value);

        if (empty($raw)) {
            throw new UnableToParseETag(sprintf('Unable to parse ETag value from given string: %s', $value));
        }

        return static::make($raw, $isWeak);
    }

    /**
     * @inheritDoc
     */
    public function raw(): string
    {
        return $this->rawValue;
    }

    /**
     * @inheritDoc
     */
    public function value(): string
    {
        $value = '"' . $this->raw() . '"';

        if ($this->isWeak()) {
            return static::WEAK_INDICATOR . $value;
        }

        return $value;
    }

    /**
     * @inheritDoc
     */
    public function isWeak(): bool
    {
        return $this->isWeak;
    }

    /**
     * @inheritDoc
     */
    public function isStrong(): bool
    {
        return !$this->isWeak();
    }

    /**
     * @inheritDoc
     */
    public function isWildcard(): bool
    {
        return $this->isWildcard;
    }

    /**
     * @inheritDoc
     */
    public function matches(ETagInterface|string $eTag, bool $strongComparison = false): bool
    {
        $eTag = $eTag instanceof ETagInterface
            ? $eTag
            : static::parseSingle($eTag);

        // When either etags are wildcards, return true. Note, this isn't exactly clearly defined
        // in rfc9110's example comparisons table. But, it is mentioned as a valid value, in the
        // directives descriptions.
        // @see https://httpwg.org/specs/rfc9110.html#field.if-match
        // @see https://httpwg.org/specs/rfc9110.html#field.if-none-match
        if ($this->isWildcard() || $eTag->isWildcard()) {
            return true;
        }

        // When strong comparison is used, then neither etags are weak...
        // @see https://httpwg.org/specs/rfc9110.html#rfc.section.8.8.3.2
        if ($strongComparison && ($this->isWeak() || $eTag->isWeak())) {
            return false;
        }

        return hash_equals($this->raw(), $eTag->raw());
    }

    /**
     * @inheritDoc
     */
    public function doesNotMatch(ETagInterface|string $eTag, bool $strongComparison = false): bool
    {
        return !$this->matches($eTag, $strongComparison);
    }

    /**
     * @inheritDoc
     */
    public function toString(): string
    {
        return $this->value();
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return $this->toString();
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Extracts a single etag value (raw value) from given string
     *
     * @param  string  $value E.g. 'W/"gh665ft"'
     *
     * @return string|null Null if unable to extract value
     */
    protected static function extractRawValue(string $value): string|null
    {
        if ($value === static::WILDCARD_SYMBOL) {
            return $value;
        }

        if (preg_match('/"([^"]+)"/', $value, $matches)) {
            return $matches[1];
        }

        return null;
    }
}
