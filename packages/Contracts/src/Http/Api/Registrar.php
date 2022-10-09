<?php

namespace Aedart\Contracts\Http\Api;

/**
 * Api Resource Registrar
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Http\Api
 */
interface Registrar
{
    /**
     * Register multiple Api Resources
     *
     * @param  array  $resources key = eloquent model instance or class path,
     *                           value = api resource instance or class path
     * @return self
     */
    public function register(array $resources): static;

    /**
     * Set the Api Resource to be associated with given model
     *
     * @param string|\Illuminate\Database\Eloquent\Model $model class path or eloquent model instance
     * @param string|\Aedart\Http\Api\Resources\ApiResource $resource class path or api resource instance
     *
     * @return self
     */
    public function set($model, $resource): static;

    /**
     * Determine if an Api Resource is registered for the model
     *
     * @param string|\Illuminate\Database\Eloquent\Model $model class path or eloquent model instance
     *
     * @return bool
     */
    public function has($model): bool;

    /**
     * Get Api Resource for given model
     *
     * @param string|\Illuminate\Database\Eloquent\Model $model class path or eloquent model instance
     *
     * @return string|null Class path or null if no resource was registered for the model
     */
    public function get($model): string|null;

    /**
     * Find eloquent model by Api Resource type
     *
     * @param  string  $type Resource type (singular or plural form)
     *
     * @return string|null Eloquent model class path or null when none found
     */
    public function findModelByType(string $type): string|null;

    /**
     * Find Api resource by its type
     *
     * @param  string  $type Resource type (singular or plural form)
     *
     * @return string|null Api Resource class path or null when none found
     */
    public function findResourceByType(string $type): string|null;
}