<?php

namespace Aedart\Contracts\Utils;

/**
 * Has Driver
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Utils
 */
interface HasDriver
{
    /**
     * Returns the native driver used by this component
     *
     * @return mixed
     */
    public function driver(): mixed;
}
