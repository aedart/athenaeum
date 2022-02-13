<?php

namespace Aedart\Support\Helpers\Routing;

use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Support\Facades\URL;

/**
 * Url Generator Trait
 *
 * @see \Aedart\Contracts\Support\Helpers\Routing\UrlGeneratorAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Helpers\Routing
 */
trait UrlGeneratorTrait
{
    /**
     * Url Generator instance
     *
     * @var UrlGenerator|null
     */
    protected UrlGenerator|null $urlGenerator = null;

    /**
     * Set url generator
     *
     * @param UrlGenerator|null $generator Url Generator instance
     *
     * @return self
     */
    public function setUrlGenerator(UrlGenerator|null $generator): static
    {
        $this->urlGenerator = $generator;

        return $this;
    }

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
    public function getUrlGenerator(): UrlGenerator|null
    {
        if (!$this->hasUrlGenerator()) {
            $this->setUrlGenerator($this->getDefaultUrlGenerator());
        }
        return $this->urlGenerator;
    }

    /**
     * Check if url generator has been set
     *
     * @return bool True if url generator has been set, false if not
     */
    public function hasUrlGenerator(): bool
    {
        return isset($this->urlGenerator);
    }

    /**
     * Get a default url generator value, if any is available
     *
     * @return UrlGenerator|null A default url generator value or Null if no default value is available
     */
    public function getDefaultUrlGenerator(): UrlGenerator|null
    {
        return URL::getFacadeRoot();
    }
}
