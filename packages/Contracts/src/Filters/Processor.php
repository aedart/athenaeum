<?php

namespace Aedart\Contracts\Filters;

use Aedart\Contracts\Filters\Exceptions\InvalidParameterException;
use RuntimeException;
use Throwable;

/**
 * Http Query Parameters Processor
 *
 * @template R of \Illuminate\Http\Request
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Filters
 */
interface Processor
{
    /**
     * Creates a new filter factory instance
     *
     * @param array $options [optional]
     *
     * @return static
     */
    public static function make(array $options = []): static;

    /**
     * Process the assigned request and build query filters, based
     * on the received http query parameters.
     *
     * @param BuiltFiltersMap $built
     * @param callable(BuiltFiltersMap $built): mixed $next
     *
     * @return mixed
     *
     * @throws InvalidParameterException If http query parameters are invalid
     * @throws Throwable
     */
    public function process(BuiltFiltersMap $built, callable $next): mixed;

    /**
     * Set the current request from which the http query parameter
     * must be processed
     *
     * @param R $request
     *
     * @return self
     */
    public function fromRequest($request): static;

    /**
     * Get the current request
     *
     * @return R
     *
     * @throws RuntimeException If no request was assigned
     */
    public function request();

    /**
     * Set name of Http query parameter to be used for building
     * one or more filters
     *
     * @param string $parameter
     *
     * @return self
     */
    public function usingParameter(string $parameter): static;

    /**
     * Get the name of the http query parameter
     *
     * @return string
     *
     * @throws RuntimeException If parameter was not assigned
     */
    public function parameter(): string;

    /**
     * Returns the http query parameters value
     *
     * @return array|string|int|float|null
     */
    public function value(): array|string|int|float|null;

    /**
     * Set state of whether processors most be forced
     * applied, regardless if a matching parameter was requested
     * or not.
     *
     * @param bool $force [optional]
     *
     * @return self
     */
    public function force(bool $force = true): static;

    /**
     * Determine whether processors most be forced
     * applied, regardless if a matching parameter was requested
     * or not.
     *
     * @see force()
     *
     * @return bool
     */
    public function mustBeApplied(): bool;
}
