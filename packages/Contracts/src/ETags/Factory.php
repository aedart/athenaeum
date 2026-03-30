<?php

namespace Aedart\Contracts\ETags;

use Aedart\Contracts\ETags\Exceptions\ETagException;
use Aedart\Contracts\ETags\Exceptions\ProfileNotFoundException;

/**
 * ETag Generator Factory
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\ETags
 */
interface Factory
{
    /**
     * Creates a new ETag generator instance or returns existing
     *
     * @param  string|null  $profile  [optional] Name of generator profile to obtain or create
     * @param  array  $options  [optional] Generator options
     *
     * @return Generator
     *
     * @throws ProfileNotFoundException
     */
    public function profile(string|null $profile = null, array $options = []): Generator;

    /**
     * Creates a new ETag generator instance
     *
     * @param  class-string<Generator>|null  $driver  [optional] Class path to the {@see Generator} "driver"
     * @param  array  $options  [optional] Generator specific options
     *
     * @return Generator
     */
    public function generator(string|null $driver = null, array $options = []): Generator;

    /**
     * Returns a default ETag Generator class path
     *
     * @return class-string<Generator>
     */
    public function defaultGenerator(): string;

    /**
     * Creates a collection of Etags from given raw http header value
     *
     * Alias for {@see ETag::parse()}
     *
     * @param  string  $rawHeaderValue E.g. W/"15487", W/"r2d23574", W/"c3pio784"
     *
     * @return Collection
     *
     * @throws ETagException If unable to parse given value
     */
    public function parse(string $rawHeaderValue): Collection;

    /**
     * Creates a single new ETag instance from given value
     *
     * Alias for {@see ETag::parseSingle()}
     *
     * @param  string  $value E.g. "33a64df551425fcc55e4d42a148795d9f25f89d4", W/"0815" or * (wildcard)
     *
     * @return ETag
     *
     * @throws ETagException If unable to parse given value
     */
    public function parseSingle(string $value): ETag;

    /**
     * Creates a new ETag instance for the raw value
     *
     * Alias for {@see ETag::make}
     *
     * @param  string  $rawValue The raw value of the eTag.
     * @param  bool  $isWeak  [optional]
     *
     * @return ETag
     *
     * @throws ETagException If empty string provided as raw value
     */
    public function makeRaw(string $rawValue, bool $isWeak = false): ETag;
}
