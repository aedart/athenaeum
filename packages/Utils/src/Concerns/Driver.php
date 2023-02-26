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
        if (isset($this->driver)) {
            return $this->driver;
        }

        return $this->driver = $this->makeDriver();
    }

    /**
     * Creates a new native driver instance
     *
     * @return mixed
     */
    abstract protected function makeDriver(): mixed;
}
