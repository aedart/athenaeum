<?php

namespace Aedart\Contracts\Support\Helpers\Foundation;

/**
 * Vite Aware
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Contracts\Support\Helpers\Foundation
 */
interface ViteAware
{
    /**
     * Set vite
     *
     * @param \Illuminate\Foundation\Vite|null $helper Vite helper instance
     *
     * @return self
     */
    public function setVite($helper): static;

    /**
     * Get vite
     *
     * If no vite has been set, this method will
     * set and return a default vite, if any such
     * value is available
     *
     * @return \Illuminate\Foundation\Vite|null vite or null if none vite has been set
     */
    public function getVite();

    /**
     * Check if vite has been set
     *
     * @return bool True if vite has been set, false if not
     */
    public function hasVite(): bool;

    /**
     * Get a default vite value, if any is available
     *
     * @return \Illuminate\Foundation\Vite|null A default vite value or Null if no default value is available
     */
    public function getDefaultVite();
}