<?php

namespace Aedart\Contracts\ETags;

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
    public function make(string|null $profile = null, array $options = []): Generator;

    /**
     * Creates a new ETag generator instance
     *
     * @param  string|null  $driver  [optional] Class path to the {@see Generator} "driver"
     * @param  array  $options  [optional] Generator specific options
     *
     * @return Generator
     */
    public function generator(string|null $driver = null, array $options = []): Generator;

    /**
     * Returns a default ETag Generator class path
     *
     * @return string
     */
    public function defaultGenerator(): string;
}