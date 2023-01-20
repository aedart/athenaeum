<?php

namespace Aedart\Contracts\Filters;

/**
 * Filters Builder
 *
 * Responsible for processing a request and built appropriate
 * query filters
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Filters
 */
interface Builder
{
    /**
     * Creates a new Request Filters Builder instance
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return static
     */
    public static function make($request): static;

    /**
     * Returns map of http query parameters and their
     * corresponding processors to be applied.
     *
     * @return Processor[] Key-value, key = http query parameter, value = processor
     */
    public function processors(): array;

    /**
     * Build the query filters to be applied
     *
     * @return BuiltFiltersMap
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function build(): BuiltFiltersMap;
}
