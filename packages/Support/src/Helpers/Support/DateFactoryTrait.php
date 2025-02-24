<?php

namespace Aedart\Support\Helpers\Support;

use Illuminate\Support\DateFactory;
use Illuminate\Support\Facades\Date;

/**
 * Date Factory Trait
 *
 * @see \Aedart\Contracts\Support\Helpers\Support\DateFactoryAware
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Support\Helpers\Support
 */
trait DateFactoryTrait
{
    /**
     * Date Factory instance
     *
     * @var DateFactory|null
     */
    protected DateFactory|null $dateFactory = null;

    /**
     * Set date factory
     *
     * @param \Illuminate\Support\DateFactory|null $factory Date Factory instance
     *
     * @return self
     */
    public function setDateFactory($factory): static
    {
        $this->dateFactory = $factory;

        return $this;
    }

    /**
     * Get date factory
     *
     * If no date factory has been set, this method will
     * set and return a default date factory, if any such
     * value is available
     *
     * @return \Illuminate\Support\DateFactory|null date factory or null if none date factory has been set
     */
    public function getDateFactory()
    {
        if (!$this->hasDateFactory()) {
            $this->setDateFactory($this->getDefaultDateFactory());
        }
        return $this->dateFactory;
    }

    /**
     * Check if date factory has been set
     *
     * @return bool True if date factory has been set, false if not
     */
    public function hasDateFactory(): bool
    {
        return isset($this->dateFactory);
    }

    /**
     * Get a default date factory value, if any is available
     *
     * @return \Illuminate\Support\DateFactory|null A default date factory value or Null if no default value is available
     */
    public function getDefaultDateFactory()
    {
        return Date::getFacadeRoot();
    }
}
