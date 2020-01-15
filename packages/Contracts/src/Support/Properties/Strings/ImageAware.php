<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * Image Aware
 *
 * Component is aware of string "image"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface ImageAware
{
    /**
     * Set image
     *
     * @param string|null $location Path, Uri or other type of location to an image
     *
     * @return self
     */
    public function setImage(?string $location);

    /**
     * Get image
     *
     * If no "image" value set, method
     * sets and returns a default "image".
     *
     * @see getDefaultImage()
     *
     * @return string|null image or null if no image has been set
     */
    public function getImage() : ?string;

    /**
     * Check if "image" has been set
     *
     * @return bool True if "image" has been set, false if not
     */
    public function hasImage() : bool;

    /**
     * Get a default "image" value, if any is available
     *
     * @return string|null Default "image" value or null if no default value is available
     */
    public function getDefaultImage() : ?string;
}
