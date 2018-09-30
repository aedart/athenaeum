<?php

namespace Aedart\Contracts\Support\Helpers\Routing;

use Illuminate\Contracts\Routing\UrlGenerator;

/**
 * Url Generator Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Helpers\Routing
 */
interface UrlGeneratorAware
{
    /**
     * Set url generator
     *
     * @param UrlGenerator|null $generator Url Generator instance
     *
     * @return self
     */
    public function setUrlGenerator(?UrlGenerator $generator);

    /**
     * Get url generator
     *
     * If no url generator has been set, this method will
     * set and return a default url generator, if any such
     * value is available
     *
     * @see getDefaultUrlGenerator()
     *
     * @return UrlGenerator|null url generator or null if none url generator has been set
     */
    public function getUrlGenerator(): ?UrlGenerator;

    /**
     * Check if url generator has been set
     *
     * @return bool True if url generator has been set, false if not
     */
    public function hasUrlGenerator(): bool;

    /**
     * Get a default url generator value, if any is available
     *
     * @return UrlGenerator|null A default url generator value or Null if no default value is available
     */
    public function getDefaultUrlGenerator(): ?UrlGenerator;
}
