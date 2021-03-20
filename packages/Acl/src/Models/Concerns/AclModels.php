<?php

namespace Aedart\Acl\Models\Concerns;

use Aedart\Contracts\Database\Models\Sluggable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

/**
 * Concerns Acl Models
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

        // When a collection of models is given
        if ($models instanceof Collection) {
            // Ensure all instances are of requested type
            return $models->filter(function ($permission) use ($class) {
                return $permission instanceof $class;
            });
        }

        // When an array of permissions is given...
        if (is_array($models)) {
            $model = $type;

            return $model
                ->newQuery()
                ->whereSlugIn($models)
                ->orWhereIn($model->getKeyName(), $models)
                ->get();
        }

        // Unable to resolve
        throw new InvalidArgumentException(sprintf(
        'Unable to resolve or find requested models. Accepted values are slugs, ids or instances. %s given',
            gettype($models)
        ));
    }
}