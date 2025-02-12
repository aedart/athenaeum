<?php

namespace Aedart\Contracts\Database\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;

/**
 * Sluggable
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Database\Models
 */
interface Sluggable
{
    /**
     * Default slug key name
     */
    public const string DEFAULT_SLUG_KEY_NAME = 'slug';

    /**
     * Returns the name of the slug key
     *
     * @return string Name of slug key or a default slug key name,
     *                if model has none specified.
     */
    public function getSlugKeyName(): string;

    /**
     * Returns the slug key
     *
     * @return string|null
     */
    public function getSlugKey(): string|null;

    /**
     * Find model by given slug
     *
     * @param string $slug
     * @param string[] $columns [optional]
     *
     * @return \Illuminate\Database\Eloquent\Model|static|null
     */
    public static function findBySlug(string $slug, array $columns = ['*']);

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
    public static function findBySlugOrFail(string $slug, array $columns = ['*']);

    /**
     * Find model by given slug or create new model
     *
     * @param string $slug
     * @param array $values [optional]
     *
     * @return \Illuminate\Database\Eloquent\Model|static
     */
    public static function findOrCreateBySlug(string $slug, array $values = []);

    /**
     * Find multiple models by given slugs
     *
     * @param string|string[] $slugs
     * @param string[] $columns [optional]
     *
     * @return static[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function findManyBySlugs(string|array $slugs, array $columns = ['*']);

    /**
     * Query scope for finding model via given slug
     *
     * @param Builder $scope
     * @param string $slug
     *
     * @return Builder
     */
    public function scopeWhereSlug(Builder $scope, string $slug): Builder;

    /**
     * Query scope for finding models that match given slugs
     *
     * @param Builder $scope
     * @param string|string[] $slugs
     *
     * @return Builder
     */
    public function scopeWhereSlugIn(Builder $scope, string|array $slugs): Builder;

    /**
     * Query scope for finding models that do not match given slugs
     *
     * @param Builder $scope
     * @param string|string[] $slugs
     *
     * @return Builder
     */
    public function scopeWhereSlugNotIn(Builder $scope, string|array $slugs): Builder;
}
