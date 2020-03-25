<?php

namespace Aedart\Contracts\Http\Clients\Requests;

/**
 * Has Driver Options
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Http\Clients\Requests
 */
interface HasDriverOptions
{
    /**
     * Returns driver specific options
     *
     * @return array
     */
    public function getDriverOptions(): array;
}