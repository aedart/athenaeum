<?php

namespace Aedart\Utils\Concerns;

/**
 * Concerns Driver
 *
 * @see \Aedart\Contracts\Utils\HasDriver
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Utils\Concerns
 */
trait Driver
{
    /**
     * The native / underlying driver
     *
     * @var mixed|null
     */
    protected mixed $driver = null;

    /**
     * Returns the native driver used by this component
     *
     * @return mixed
     */
    public function driver(): mixed
    {
        if ($this->hasDriver()) {
            return $this->driver;
        }

        return $this->swapDriver(
            $this->makeDriver()
        );
    }

    /**
     * Creates a new native driver instance
     *
     * @return mixed
     */
    abstract protected function makeDriver(): mixed;

    /**
     * Swap the existing native driver with a new instance
     *
     * @param  mixed  $newDriver
     *
     * @return mixed The new driver
     */
    protected function swapDriver(mixed $newDriver): mixed
    {
        return $this->driver = $newDriver;
    }

    /**
     * Determine if a driver has been initialised
     *
     * @return bool
     */
    protected function hasDriver(): bool
    {
        return isset($this->driver);
    }
}
