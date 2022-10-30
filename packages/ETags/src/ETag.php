<?php

namespace Aedart\ETags;

use Aedart\Contracts\ETags\ETag as ETagInterface;
use Aedart\ETags\Exceptions\UnableToParseETag;

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
     * Weak ETag indicator / prefix
     */
    protected const WEAK_INDICATOR = 'W/';

    /**
     * Creates a new ETag instance
     *
     * @param  string  $rawValue
     * @param  bool  $isWeak  [optional]
     */
    public function __construct(
        protected string $rawValue,
        protected bool $isWeak = false
    ) {}

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
    public static function parse(string $value): static
    {
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
    public function matches(ETagInterface|string $eTag): bool
    {
        if (!($eTag instanceof ETagInterface)) {
            $eTag = static::parse($eTag);
        }

        return hash_equals($this->raw(), $eTag->raw());
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
     * Extracts raw value from given HTTP header value
     *
     * @param  string  $value HTTP header value
     *
     * @return string|null Null if unable to extract value
     */
    protected static function extractRawValue(string $value): string|null
    {
        if (preg_match('/"([^"]+)"/', $value, $matches)) {
            return $matches[1];
        }

        return null;
    }
}