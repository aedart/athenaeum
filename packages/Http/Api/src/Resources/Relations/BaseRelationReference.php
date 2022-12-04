<?php

namespace Aedart\Http\Api\Resources\Relations;

use Aedart\Contracts\Http\Api\Resources\Relations\Exceptions\RelationReferenceException as RelationReferenceExceptionInterface;
use Aedart\Contracts\Http\Api\Resources\Relations\RelationReference;
use Aedart\Http\Api\Resources\ApiResource;
use Aedart\Http\Api\Resources\Relations\Exceptions\CannotInvokeCallback;
use Aedart\Http\Api\Resources\Relations\Exceptions\RelationReferenceException;
use Aedart\Http\Api\Traits\ApiResourceRegistrarTrait;
use Aedart\Utils\Str;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Base Relation Reference
 *
 * @see RelationReference
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Api\Resources\Relations
 */
abstract class BaseRelationReference implements RelationReference
{
    use ApiResourceRegistrarTrait;
    use Concerns\PrimaryKey;
    use Concerns\Label;
    use Concerns\ResourceType;
    use Concerns\SelfLink;
    use Concerns\AdditionalFormatting;

    /**
     * Default value to use when relation not loaded
     *
     * @var callable|mixed
     */
    protected $defaultValue = null;

    /**
     * Callback to be applied on loaded relation
     *
     * @var callable|null
     */
    protected $whenLoadedCallback = null;

    /**
     * Current request
     *
     * @var Request|null
     */
    protected Request|null $request = null;

    /**
     * Creates a new relation reference
     *
     * @param  \Aedart\Http\Api\Resources\ApiResource|mixed  $resource
     * @param  string  $relation Name of eloquent model relation
     */
    public function __construct(
        protected mixed $resource,
        protected string $relation
    ) {
    }

    /**
     * @inheritDoc
     */
    public function toValue(): mixed
    {
        $relation = $this->getEagerLoadedRelation();

        // Return the "default" value when relation is not
        // loaded in the eloquent model
        if (!isset($relation)) {
            return $this->resolveDefaultValue();
        }

        // Apply callback on relation and resolve the value
        // this relation reference represents.
        return $this->applyWhenLoaded($relation);
    }

    /**
     * @inheritDoc
     */
    public function whenLoaded(callable $callback): static
    {
        $this->whenLoadedCallback = $callback;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function otherwise($default = null): static
    {
        return $this->defaultTo($default);
    }

    /**
     * @inheritDoc
     */
    public function defaultTo($default = null): static
    {
        $this->defaultValue = $default;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function withRequest($request): static
    {
        $this->request = $request;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @inheritDoc
     */
    public function getApiResource()
    {
        return $this->resource;
    }

    /**
     * @inheritDoc
     */
    public function getModel()
    {
        return $this->getApiResource()->resource;
    }

    /**
     * @inheritDoc
     */
    public function getEagerLoadedRelation()
    {
        $relation = $this->getRelationName();
        $parent = $this->getModel();

        if (!isset($parent)) {
            return null;
        }

        return $this->loadNestedRelation($parent, $relation);
    }

    /**
     * @inheritDoc
     */
    public function getRelationName(): string
    {
        return $this->relation;
    }

    /*****************************************************************
     * Default Formatting of Loaded Model(s)
     ****************************************************************/

    /**
     * Formats a single relation model as this reference's value
     *
     * @param  Model  $related
     * @param  static  $relationReference
     *
     * @return mixed Formatted reference value
     *
     * @throws RelationReferenceExceptionInterface
     */
    public function formatSingleLoadedModel(Model $related, $relationReference): mixed
    {
        // Obtain the relation's primary identifier and return it directly,
        // when relation must be formatted as a primitive value.
        $identifier = $this->resolveIdentifier($related, $relationReference->getPrimaryKeyName(), $relationReference);

        if ($relationReference->mustReturnRawIdentifier()) {
            return $identifier;
        }

        // Format reference's value. Obtain attributes to be displayed.
        $output = $this->addRelatedModelPrimaryKey([], $identifier, $related, $relationReference);

        // Add label, if needed
        $output = $this->addLabel($output, $related, $relationReference);

        // Show Resource Type, if needed
        $output = $this->addResourceType($output, $related, $relationReference);

        // Show self link,...
        $output = $this->addSelfLink($output, $related, $relationReference);

        // Finally, apply an evt. "additional" callback that allows developer
        // to add or change the final output entirely.
        return $this->applyAdditionalFormatting($output, $related, $relationReference);
    }

    /**
     * Formats a multiple related model as this reference's value
     *
     * @param  Collection<Model>  $related
     * @param  static  $relationReference
     *
     * @return array List of reference values, one for each related model
     */
    public function formatMultipleLoadedModels(Collection $related, $relationReference): array
    {
        return $related->map(function (Model $model) use ($relationReference) {
            return $relationReference->formatSingleLoadedModel($model, $relationReference);
        })->toArray();
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Invokes the "when loaded" callback on given relation
     *
     * @param  Model|Collection  $loadedRelation
     *
     * @return mixed
     *
     * @throws RelationReferenceExceptionInterface
     */
    protected function applyWhenLoaded(Model|Collection $loadedRelation): mixed
    {
        $whenLoaded = $this->whenLoadedCallback;

        if (!is_callable($whenLoaded)) {
            throw new CannotInvokeCallback(sprintf(
                '"When loaded" callback is not callable, for "%s" relation in %s Api Resource',
                $this->getRelationName(),
                optional($this->getApiResource())->type() ?? 'unknown'
            ));
        }

        return $whenLoaded($loadedRelation, $this);
    }

    /**
     * Resolves the default value
     *
     * @return mixed
     */
    protected function resolveDefaultValue(): mixed
    {
        $value = $this->defaultValue;

        if (is_callable($value)) {
            return $value($this);
        }

        return $value;
    }

    /**
     * Find the corresponding Api Resource for given related eloquent model, or fail
     *
     * @param  Model  $relation
     * @param  static|null $relationReference  [optional]
     *
     * @return ApiResource
     *
     * @throws RelationReferenceExceptionInterface
     */
    protected function findApiResourceOrFail(Model $relation, $relationReference = null): ApiResource
    {
        $resourceClass = $this->getApiResourceRegistrar()->get($relation);

        if (!isset($resourceClass)) {
            $relationReference = $relationReference ?? $this;

            throw new RelationReferenceException(sprintf(
                'No matching Api Resource found for "%s" relation, in %s resource',
                $relationReference->getRelationName(),
                $relationReference->getApiResource()->type()
            ));
        }

        return $resourceClass::make($relation);
    }

    /**
     * Load nested relation from parent model
     *
     * @param  Model  $parent
     * @param  string  $relation Name of relation to load
     *
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection<\Illuminate\Database\Eloquent\Model>|null
     */
    protected function loadNestedRelation(Model $parent, string $relation)
    {
        // Skip if the requested relation is empty... (edge case)
        if (empty($relation)) {
            return null;
        }

        // By default, we assume that requested relation name is not a nested
        // relation and attempt to obtain it directly.
        if ($parent->relationLoaded($relation) && isset($parent->{$relation})) {
            return $parent->getRelation($relation);
        }

        // If no relation was obtained, we check if requested relation contains a dot.
        // In such a case, it means that requested relation is a nested relation. We
        // must traverse the chain to get it.
        if (Str::contains($relation, '.')) {
            $relations = explode('.', $relation);

            // Get the name of the "top most" relation (parent). If it is loaded,
            // obtain it and attempt to load it's nested relation.
            $nested = array_shift($relations);

            if ($parent->relationLoaded($nested) && isset($parent->{$nested})) {
                return $this->loadNestedRelation($parent->getRelation($nested), implode('.', $relations));
            }
        }

        return null;
    }
}
