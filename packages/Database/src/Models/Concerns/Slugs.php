<?php

namespace Aedart\Database\Models\Concerns;

use Aedart\Contracts\Database\Models\Sluggable;

/**
 * Concerns Slugs
 *
 * @see \Aedart\Contracts\Database\Models\Sluggable
 *
 * @method static \Illuminate\Database\Eloquent\Builder whereSlug(string $slug)
 * @method static \Illuminate\Database\Eloquent\Builder whereSlugIn(mixed $slugs)
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Database\Models\Concerns
 */
trait Slugs
{
    /**
     * Returns the name of the slug key
     *
     * @return string Name of slug key or a default slug key name,
     *                if model has none specified.
     */
    public function getSlugKeyName(): string
    {
        if (property_exists($this, 'slugKey')) {
            return $this->slugKey;
        }

        return Sluggable::DEFAULT_SLUG_KEY_NAME;
    }

    /**
     * Returns the slug key
     *
     * @return string|null
     */
    public function getSlugKey(): ?string
    {
        return $this->getAttribute($this->getSlugKeyName());
    }

    /**
     * Find model by given slug
     *
     * @param string $slug
     * @param string[] $columns [optional]
     *
     * @return \Illuminate\Database\Eloquent\Model|static|null
     */
    public static function findBySlug(string $slug, array $columns = ['*'])
    {
        return static::whereSlug($slug)->first($columns);
    }

    /**
     * Find model by given slug or fail
     *
     * @param string $slug
     * @param string[] $columns [optional]
     *
     * @return \Illuminate\Database\Eloquent\Model|static
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \Illuminate\Database\MultipleRecordsFoundException
     */
    public static function findBySlugOrFail(string $slug, array $columns = ['*'])
    {
        return static::whereSlug($slug)->sole($columns);
    }

    /**
     * Find model by given slug or create new model
     *
     * @param string $slug
     * @param array $values [optional]
     *
     * @return \Illuminate\Database\Eloquent\Model|static
     */
    public static function findOrCreateBySlug(string $slug, array $values = [])
    {
        $slugName = (new static())->getSlugKeyName();

        // Find or create
        return static::firstOrCreate([ $slugName => $slug ], $values);
    }

    /**
     * Find multiple models by given slugs
     *
     * @param mixed $slugs
     * @param string[] $columns [optional]
     *
     * @return static[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function findManyBySlugs($slugs, array $columns = ['*'])
    {
        return static::whereSlugIn($slugs)->get($columns);
    }

    /**
     * Query scope for finding model via given slug
     *
     * @param \Illuminate\Database\Eloquent\Builder $scope
     * @param string $slug
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereSlug($scope, string $slug)
    {
        return $scope->where($this->getSlugKeyName(), $slug);
    }

    /**
     * Query scope for finding models that match given slugs
     *
     * @param \Illuminate\Database\Eloquent\Builder $scope
     * @param mixed $slugs
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereSlugIn($scope, $slugs)
    {
        return $scope->whereIn($this->getSlugKeyName(), $slugs);
    }
}
