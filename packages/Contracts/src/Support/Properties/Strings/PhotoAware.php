<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Photo Aware
 *
 * Component is aware of string "photo"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface PhotoAware
{
    /**
     * Set photo
     *
     * @param string|null $location Path, Uri or other type of location to a photo
     *
     * @return self
     */
    public function setPhoto(string|null $location): static;

    /**
     * Get photo
     *
     * If no photo value set, method
     * sets and returns a default photo.
     *
     * @see getDefaultPhoto()
     *
     * @return string|null photo or null if no photo has been set
     */
    public function getPhoto(): string|null;

    /**
     * Check if photo has been set
     *
     * @return bool True if photo has been set, false if not
     */
    public function hasPhoto(): bool;

    /**
     * Get a default photo value, if any is available
     *
     * @return string|null Default photo value or null if no default value is available
     */
    public function getDefaultPhoto(): string|null;
}
