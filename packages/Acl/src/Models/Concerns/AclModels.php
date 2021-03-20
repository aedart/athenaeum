<?php

namespace Aedart\Acl\Models\Concerns;

use Aedart\Contracts\Database\Models\Sluggable;
use Aedart\Utils\Arr;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

/**
 * Concerns Acl Models
 *
 * Provides common functionality for various ACL related Eloquent models.
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Acl\Models\Concerns
 */
trait AclModels
{
    use Configuration;

    /*****************************************************************
     * Find methods
     ****************************************************************/

    /**
     * Determine if given models are related (granted or assigned) to this model
     *
     * @param string|int|Model|Collection|string[]|int[]|Model[] $models
     * @param Model|Sluggable $type Instance of the acl model type
     * @param string $relation Name of target relation to match against (has many / belongs to many)
     *
     * @return bool
     *
     * @throws InvalidArgumentException
     */
    protected function hasRelatedModels($models, $type, string $relation): bool
    {
        // When a model's id is given
        if (is_numeric($models)) {
            return $this->{$relation}->contains($type->getKeyName(), $models);
        }

        // When a model's slug is given
        if (is_string($models)) {
            return $this->{$relation}->contains($type->getSlugKeyName(), $models);
        }

        // When a model instance is given
        $class = get_class($type);
        if ($models instanceof $class) {
            return $this->{$relation}->contains($type->getKeyName(), $models->id);
        }

        // When an array is given, convert it to a collection - but ONLY if it's not
        // an associative array!
        if (is_array($models) && !Arr::isAssoc($models)) {
            $models = new Collection($models);
        }

        // When a collection of models is given
        if ($models instanceof Collection) {
            return $models->intersect($this->{$relation})->isNotEmpty();
        }

        // Unable to determine how to check given model, thus we must fail...
        throw new InvalidArgumentException(sprintf(
        'Unable to determine is given models are related. Accepted values are slugs, ids, collection of models or model instance. %s given',
            gettype($models)
        ));
    }

    /**
     * Determine if any (one of) given models is assigned or granted
     *
     * @param string[]|int[]|Model[]|Collection $models Slugs, ids or collection or model instances
     * @param Model|Sluggable $type Instance of the acl model type
     * @param string $relation Name of target relation to match against (has many / belongs to many)
     *
     * @return bool
     *
     * @throws InvalidArgumentException
     */
    protected function hasAnyOf($models, $type, string $relation): bool
    {
        foreach ($models as $model) {
            if ($this->hasRelatedModels($model, $type, $relation)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine if all of given models is assigned or granted
     *
     * @param string[]|int[]|Model[]|Collection $models Slugs, ids or collection or model instances
     * @param Model|Sluggable $type Instance of the acl model type
     * @param string $relation Name of target relation to match against (has many / belongs to many)
     *
     * @return bool
     *
     * @throws InvalidArgumentException
     */
    protected function hasAllOf($models, $type, string $relation): bool
    {
        foreach ($models as $model) {
            if (!$this->hasRelatedModels($model, $type, $relation)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Obtains ids for given models
     *
     * @param Model|Sluggable $type Instance of the acl model type
     * @param mixed ...$models
     *
     * @return int[]
     *
     * @throws InvalidArgumentException
     */
    protected function obtainModelIds($type, ...$models): array
    {
        return collect($models)
            ->flatten()
            ->map(function ($model) use($type) {
                return $this->resolveOrFindModels($model, $type);
            })
            ->map->id
            ->all();
    }

    /**
     * Resolves or finds given models
     *
     * @param string|int|Model|string[]|int[]|Model[]|Collection $models
     * @param Model|Sluggable $type Instance of the acl model type
     *
     * @return Collection|Model[]
     *
     * @throws InvalidArgumentException
     */
    protected function resolveOrFindModels($models, $type)
    {
        $class = get_class($type);
        if ($models instanceof $class) {
            return $models;
        }

        // When id is given
        if (is_numeric($models)) {
            return $class::find($models);
        }

        // When slug is given
        if (is_string($models)) {
            return $class::findBySlug($models);
        }

        // When array is given, with model instances, then convert it
        // to a collection.
        if (is_array($models)
            && count($models) > 0
            && $models[0] instanceof $class
        ) {
            $models = new Collection($models);
        }

        // When a collection of models is given
        if ($models instanceof Collection) {
            // Ensure all instances are of requested type
            return $models->filter(function ($permission) use ($class) {
                return $permission instanceof $class;
            });
        }

        // When an array of ids or slugs is given...
        if (is_array($models)
            && count($models) > 0
            && !Arr::isAssoc($models)
            && (is_numeric($models[0]) || is_string($models[0]))
        ) {
            return $type
                ->newQuery()
                ->whereSlugIn($models)
                ->orWhereIn($type->getKeyName(), $models)
                ->get();
        }

        // Unable to resolve
        throw new InvalidArgumentException(sprintf(
        'Unable to resolve or find requested models. Accepted values are slugs, ids or collection or model instances. %s given',
            gettype($models)
        ));
    }
}