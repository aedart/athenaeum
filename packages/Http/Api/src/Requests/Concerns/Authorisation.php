<?php

namespace Aedart\Http\Api\Requests\Concerns;

use Aedart\Support\Helpers\Auth\Access\GateTrait;

/**
 * Concerns Authorisation
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Api\Requests\Concerns
 */
trait Authorisation
{
    use GateTrait;

    /**
     * Determine if user is authorised to perform this request
     *
     * @see authorizeAfterValidation
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Determine if user is still authorised to perform this request,
     * after request data has been validated
     *
     * @see authorize
     *
     * @return bool
     */
    public function authorizeAfterValidation(): bool
    {
        return true;
    }

    /**
     * Returns the model in question for authorisation
     *
     * @return string|null Class path or null when no model required
     */
    abstract public function authorisationModel(): string|null;

    /**
     * Determine if ability should be granted for current user.
     * (Is user allowed to...)
     *
     * @param  string|string[]  $ability
     * @param  mixed|array  $arguments  [optional]
     *
     * @return bool
     */
    public function allows(string|array $ability, mixed $arguments = []): bool
    {
        return $this->getGate()->allows($ability, $arguments);
    }

    /**
     * Determine if ability should be denied for current user.
     * (Is user NOT allowed to...)
     *
     * @param  string|string[]  $ability
     * @param  mixed|array  $arguments  [optional]
     *
     * @return bool
     */
    public function denies(string|array $ability, mixed $arguments = []): bool
    {
        return $this->getGate()->denies($ability, $arguments);
    }
}
