<?php

namespace Aedart\Support\Helpers\Foundation;

use Illuminate\Foundation\Vite;
use Illuminate\Support\Facades\Vite as ViteFacade;

/**
 * Vite Trait
 *
 * @see \Aedart\Contracts\Support\Helpers\Foundation\ViteAware
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Support\Helpers\Foundation
 */
trait ViteTrait
{
    /**
     * Vite helper instance
     *
     * @var Vite|null
     */
    protected Vite|null $vite = null;

    /**
     * Set vite
     *
     * @param \Illuminate\Foundation\Vite|null $helper Vite helper instance
     *
     * @return self
     */
    public function setVite($helper): static
    {
        $this->vite = $helper;

        return $this;
    }

    /**
     * Get vite
     *
     * If no vite has been set, this method will
     * set and return a default vite, if any such
     * value is available
     *
     * @return \Illuminate\Foundation\Vite|null vite or null if none vite has been set
     */
    public function getVite()
    {
        if (!$this->hasVite()) {
            $this->setVite($this->getDefaultVite());
        }
        return $this->vite;
    }

    /**
     * Check if vite has been set
     *
     * @return bool True if vite has been set, false if not
     */
    public function hasVite(): bool
    {
        return isset($this->vite);
    }

    /**
     * Get a default vite value, if any is available
     *
     * @return \Illuminate\Foundation\Vite|null A default vite value or Null if no default value is available
     */
    public function getDefaultVite()
    {
        return ViteFacade::getFacadeRoot();
    }
}