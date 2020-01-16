<?php

namespace Aedart\Support\Helpers\Console;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Artisan;

/**
 * Artisan Trait
 *
 * @see \Aedart\Contracts\Support\Helpers\Console\ArtisanAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Helpers\Console
 */
trait ArtisanTrait
{
    /**
     * Artisan Kernel instance
     *
     * @var Kernel|null
     */
    protected ?Kernel $artisan = null;

    /**
     * Set artisan
     *
     * @param Kernel|null $kernel Artisan Kernel instance
     *
     * @return self
     */
    public function setArtisan(?Kernel $kernel)
    {
        $this->artisan = $kernel;

        return $this;
    }

    /**
     * Get artisan
     *
     * If no artisan has been set, this method will
     * set and return a default artisan, if any such
     * value is available
     *
     * @see getDefaultArtisan()
     *
     * @return Kernel|null artisan or null if none artisan has been set
     */
    public function getArtisan(): ?Kernel
    {
        if (!$this->hasArtisan()) {
            $this->setArtisan($this->getDefaultArtisan());
        }
        return $this->artisan;
    }

    /**
     * Check if artisan has been set
     *
     * @return bool True if artisan has been set, false if not
     */
    public function hasArtisan(): bool
    {
        return isset($this->artisan);
    }

    /**
     * Get a default artisan value, if any is available
     *
     * @return Kernel|null A default artisan value or Null if no default value is available
     */
    public function getDefaultArtisan(): ?Kernel
    {
        return Artisan::getFacadeRoot();
    }
}
