<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Image Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\ImageAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait ImageTrait
{
    /**
     * Path, Uri or other type of location to an image
     *
     * @var string|null
     */
    protected string|null $image = null;

    /**
     * Set image
     *
     * @param string|null $location Path, Uri or other type of location to an image
     *
     * @return self
     */
    public function setImage(string|null $location): static
    {
        $this->image = $location;

        return $this;
    }

    /**
     * Get image
     *
     * If no image value set, method
     * sets and returns a default image.
     *
     * @see getDefaultImage()
     *
     * @return string|null image or null if no image has been set
     */
    public function getImage(): string|null
    {
        if (!$this->hasImage()) {
            $this->setImage($this->getDefaultImage());
        }
        return $this->image;
    }

    /**
     * Check if image has been set
     *
     * @return bool True if image has been set, false if not
     */
    public function hasImage(): bool
    {
        return isset($this->image);
    }

    /**
     * Get a default image value, if any is available
     *
     * @return string|null Default image value or null if no default value is available
     */
    public function getDefaultImage(): string|null
    {
        return null;
    }
}
