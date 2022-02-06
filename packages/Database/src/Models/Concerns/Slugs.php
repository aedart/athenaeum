<?php

namespace Aedart\Database\Models\Concerns;

use Aedart\Contracts\Database\Models\Sluggable;
use Illuminate\Contracts\Database\Eloquent\Builder;

/**
 * Concerns Slugs
 *
 * @see \Aedart\Contracts\Database\Models\Sluggable
 *
 * @method static Builder whereSlug(string $slug)
 * @method static Builder whereSlugIn(mixed $slugs)
 * @method static Builder whereSlugNotIn(mixed $slugs)
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
    public function getSlugKey(): string|null
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
    public static function findManyBySlugs(string|array $slugs, array $columns = ['*'])
    {
        return static::whereSlugIn($slugs)->get($columns);
    }

    /**
     * Query scope for finding model via given slug
     *
     * @param Builder $scope
     * @param string $slug
     *
     * @return Builder
     */
    public function scopeWhereSlug(Builder $scope, string $slug): Builder
    {
        return $scope->where($this->getSlugKeyName(), $slug);
    }

    /**
     * Query scope for finding models that match given slugs
     *
     * @param Builder $scope
     * @param string|string[] $slugs
     *
     * @return Builder
     */
    public function scopeWhereSlugIn(Builder $scope, string|array $slugs): Builder
    {
        return $scope->whereIn($this->getSlugKeyName(), $slugs);
    }

    /**
     * Query scope for finding models that do not match given slugs
     *
     * @param Builder $scope
     * @param string|string[] $slugs
     *
     * @return Builder
     */
    public function scopeWhereSlugNotIn(Builder $scope, string|array $slugs): Builder
    {
        return $scope->whereNotIn($this->getSlugKeyName(), $slugs);
    }
}
