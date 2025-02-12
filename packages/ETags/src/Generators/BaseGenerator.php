<?php

namespace Aedart\ETags\Generators;

use Aedart\Contracts\ETags\ETag;
use Aedart\Contracts\ETags\Generator;
use Aedart\ETags\Exceptions\UnableToGenerateETag;
use Aedart\ETags\Facades\Generator as GeneratorFacade;
use Throwable;

/**
 * Base ETag Generator
 *
 * Abstraction for ETag generators.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\ETags\Generators
 */
abstract class BaseGenerator implements Generator
{
    /**
     * Default hashing algorithm for hashing content to be
     * used for weak comparison ETags
     */
    protected const string DEFAULT_WEAK_ALGO = 'xxh3';

    /**
     * Default hashing algorithm for hashing content to be
     * used for strong comparison ETags
     */
    protected const string DEFAULT_STRONG_ALGO = 'xxh128';

    /**
     * Create a new ETag Generator instance
     *
     * @param  array  $options  [optional]
     */
    public function __construct(
        protected array $options = []
    ) {
    }

    /**
     * @inheritDoc
     */
    public function make(mixed $content, bool $weak = true): ETag
    {
        try {
            $rawValue = $this->hashValue(
                $this->resolveContent($content, $weak),
                $weak
            );

            return $this->makeETag($rawValue, $weak);
        } catch (Throwable $e) {
            throw new UnableToGenerateETag($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @inheritdoc
     */
    public function makeWeak(mixed $content): ETag
    {
        return $this->make($content, true);
    }

    /**
     * @inheritdoc
     */
    public function makeStrong(mixed $content): ETag
    {
        return $this->make($content, false);
    }

    /**
     * Resolves the content to be hashed and used as the {@see ETag::raw} value
     *
     * @param  mixed  $content
     * @param  bool  $weak  [optional] Flag indicates if "weak" ETag is intended generated.
     *                      If able, given content is modified for either "weak" or "strong"
     *                      comparison.
     *
     * @return string Content to be hashed
     *
     * @throws UnableToGenerateETag
     */
    abstract public function resolveContent(mixed $content, bool $weak = true): string;

    /**
     * Hash given content
     *
     * @see weakHashAlgorithm
     * @see strongHashAlgorithm
     *
     * @param  string  $content
     * @param  bool  $weak  [optional] When true, a "strong" hashing algorithm is used.
     *                      When false, a "weak" hashing algorithm is used.
     *
     * @return string
     */
    protected function hashValue(string $content, bool $weak = true): string
    {
        $algorithm = $weak
            ? $this->weakHashAlgorithm()
            : $this->strongHashAlgorithm();

        return $this->hash($content, $algorithm);
    }

    /**
     * Returns a hash of given content, using specified hashing algorithm
     *
     * @param  string  $content
     * @param  string  $algorithm
     *
     * @return string
     */
    protected function hash(string $content, string $algorithm): string
    {
        return hash($algorithm, $content);
    }

    /**
     * Returns name of hashing algorithm to be used for ETags flagged as "weak" (weak comparison)
     *
     * @return string
     */
    protected function weakHashAlgorithm(): string
    {
        return $this->options['weak_algo'] ?? static::DEFAULT_WEAK_ALGO;
    }

    /**
     * Returns name of hashing algorithm to be used for ETags not flagged as "weak" (strong comparison)
     *
     * @return string
     */
    protected function strongHashAlgorithm(): string
    {
        return $this->options['strong_algo'] ?? static::DEFAULT_STRONG_ALGO;
    }

    /**
     * Creates a new ETag instance for the raw value
     *
     * @param  string  $rawValue
     * @param  bool  $weak  [optional]
     *
     * @return ETag
     */
    protected function makeETag(string $rawValue, bool $weak = true): ETag
    {
        return GeneratorFacade::makeRaw($rawValue, $weak);
    }
}
