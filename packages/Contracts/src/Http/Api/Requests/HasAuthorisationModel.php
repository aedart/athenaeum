<?php

namespace Aedart\Contracts\Http\Api\Requests;

/**
 * Has Authorisation Model
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Http\Api\Requests
 */
interface HasAuthorisationModel
{
    /**
     * Returns the model in question for authorisation
     *
     * @return class-string<Illuminate\Database\Eloquent\Model>|null Class path or null when no model required
     */
    public function authorisationModel(): string|null;
}
