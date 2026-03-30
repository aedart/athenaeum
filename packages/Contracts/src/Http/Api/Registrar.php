<?php

namespace Aedart\Contracts\Http\Api;

/**
 * Api Resource Registrar
 *
 * @template M of \Illuminate\Database\Eloquent\Model Eloquent model instance or class path
 * @template A of \Aedart\Http\Api\Resources\ApiResource API Resource instance or class path
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Http\Api
 */
interface Registrar
{
    /**
     * Register multiple Api Resources
     *
     * @param  array<M|class-string<M>, A, class-string<A>>  $resources
     *
     * @return self
     */
    public function register(array $resources): static;

    /**
     * Set the Api Resource to be associated with given model
     *
     * @param M|class-string<M> $model
     * @param A|class-string<A> $resource
     *
     * @return self
     */
    public function set($model, $resource): static;

    /**
     * Determine if an Api Resource is registered for the model
     *
     * @param M|class-string<M> $model
     *
     * @return bool
     */
    public function has($model): bool;

    /**
     * Get Api Resource for given model
     *
     * @param M|class-string<M> $model
     *
     * @return class-string<A>|null Class path or null if no resource was registered for the model
     */
    public function get($model): string|null;

    /**
     * Find eloquent model by Api Resource type
     *
     * @param  string  $type Resource type (singular or plural form)
     *
     * @return class-string<M>|null Eloquent model class path or null when none found
     */
    public function findModelByType(string $type): string|null;

    /**
     * Find Api resource by its type
     *
     * @param  string  $type Resource type (singular or plural form)
     *
     * @return class-string<A>|null Api Resource class path or null when none found
     */
    public function findResourceByType(string $type): string|null;

    /**
     * Forget Api Resource for given model
     *
     * @param M|class-string<M> $model class path or eloquent model instance
     *
     * @return bool
     */
    public function forget($model): bool;
}
