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
     * @return string|Builder|null Class path, builder instance or null if request
     *                             does not support filters
     */
    abstract public function filtersBuilder(): string|Builder|null;

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
        $builder = $this->filtersBuilder();

        if (!isset($builder)) {
            return null;
        }

        if (!($builder instanceof Builder)) {
            $builder = $builder::make($request);
        }

        return $this->modifyFilters(
            $builder->build()
        );
    }
}
