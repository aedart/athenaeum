<?php

namespace Aedart\Contracts\Support\Helpers\Support;

/**
 * Date Factory Aware
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Contracts\Support\Helpers\Support
 */
interface DateFactoryAware
{
    /**
     * Set date factory
     *
     * @param \Illuminate\Support\DateFactory|null $factory Date Factory instance
     *
     * @return self
     */
    public function setDateFactory($factory): static;

    /**
     * Get date factory
     *
     * If no date factory has been set, this method will
     * set and return a default date factory, if any such
     * value is available
     *
     * @return \Illuminate\Support\DateFactory|null date factory or null if none date factory has been set
     */
    public function getDateFactory();

    /**
     * Check if date factory has been set
     *
     * @return bool True if date factory has been set, false if not
     */
    public function hasDateFactory(): bool;

    /**
     * Get a default date factory value, if any is available
     *
     * @return \Illuminate\Support\DateFactory|null A default date factory value or Null if no default value is available
     */
    public function getDefaultDateFactory();
}