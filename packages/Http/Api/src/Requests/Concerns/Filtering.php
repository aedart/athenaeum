<?php

namespace Aedart\Http\Api\Requests\Concerns;

use Aedart\Contracts\Filters\Builder;
use Aedart\Contracts\Filters\BuiltFiltersMap;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

/**
 * Concerns Filtering
 *
 * @see \Aedart\Contracts\Filters\Builder
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Api\Requests\Concerns
 */
trait Filtering
{
    /**
     * Filters to be applied
     *
     * @var BuiltFiltersMap|null
     */
    public BuiltFiltersMap|null $filters = null;

    /**
     * Request filters builder to use for this request
     *
     * @return string|null Class path or null if request does not support filters
     */
    abstract public function filtersBuilder(): string|null;

    /**
     * Modifies the built filters, before they are applied
     *
     * @param  BuiltFiltersMap  $filters
     *
     * @return BuiltFiltersMap
     */
    public function modifyFilters(BuiltFiltersMap $filters): BuiltFiltersMap
    {
        // Modify the built filters when required. E.g. add additional restrictions,
        // based on current request...

        return $filters;
    }

    /**
     * Prepares filters to be applied
     *
     * @param  Validator  $validator
     *
     * @return void
     *
     * @throws ValidationException
     */
    public function prepareFilters(Validator $validator): void
    {
        $this->filters = $this->resolveFiltersFromRequest($this);
    }

    /**
     * Creates a new filters builder instance
     *
     * @param  string  $builderClass
     * @param  Request  $request
     *
     * @return Builder
     */
    public function makeFiltersBuilder(string $builderClass, Request $request): Builder
    {
        return $builderClass::make($request);
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Resolves the filters to be applied for given request
     *
     * @param  Request  $request
     *
     * @return BuiltFiltersMap|null
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function resolveFiltersFromRequest(Request $request): BuiltFiltersMap|null
    {
        $builderClass = $this->filtersBuilder();

        if (!isset($builderClass)) {
            return null;
        }

        $builder = $this->makeFiltersBuilder($builderClass, $request);

        return $this->modifyFilters(
            $builder->build()
        );
    }
}
