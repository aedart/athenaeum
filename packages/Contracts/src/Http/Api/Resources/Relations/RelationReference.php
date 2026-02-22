<?php

namespace Aedart\Contracts\Http\Api\Resources\Relations;

use Aedart\Contracts\Http\Api\Resources\Relations\Exceptions\RelationReferenceException;

/**
 * Relation Reference
 *
 * @template M of \Illuminate\Database\Eloquent\Model
 * @template C of \Illuminate\Database\Eloquent\Collection<M>
 * @template R of \Illuminate\Http\Request
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Http\Api\Resources\Relations
 */
interface RelationReference
{
    /**
     * Returns a value representation of the eloquent relation
     *
     * Method is intended to be used for when merging
     * this relation into an Api Resource's formatted payload
     *
     * @return mixed
     *
     * @throws RelationReferenceException
     */
    public function toValue(): mixed;

    /**
     * Set callback that formats the loaded relation
     *
     * @param  callable(M|C $relation, static $relationReference): mixed  $callback
     *                             The eager-loaded relation model or collection is given
     *                             as callback argument, along with this relation reference.
     *                             The callback MUST return some kind of value. Null is a
     *                             valid return value.
     *
     *
     * @return self
     */
    public function whenLoaded(callable $callback): static;

    /**
     * Alias for {@see defaultTo}
     *
     * @param callable(static $relationReference): mixed|mixed $default
     *
     * @return self
     */
    public function otherwise(mixed $default = null): static;

    /**
     * Set the default value to return when relation
     * is not loaded or available
     *
     * @param callable(static $relationReference): mixed|mixed $default  [optional] When callback is given, then this
     *                                 relation reference is given as argument.
     *
     * @return self
     */
    public function defaultTo(mixed $default = null): static;

    /**
     * Set the current request
     *
     * @param R $request
     *
     * @return self
     */
    public function withRequest($request): static;

    /**
     * Returns the current request
     *
     * @return R|null
     */
    public function getRequest();

    /**
     * Returns the Api Resource
     *
     * @return \Aedart\Http\Api\Resources\ApiResource
     */
    public function getApiResource();

    /**
     * Returns the Api Resource's assigned Eloquent model,
     * that contains the target relation
     *
     * @return M|null
     */
    public function getModel();

    /**
     * Returns related model or collection of models,
     * if the relation was eager loaded
     *
     * @return M|C|null
     */
    public function getEagerLoadedRelation();

    /**
     * The name of the eloquent relation in question
     *
     * @return string
     */
    public function getRelationName(): string;
}
