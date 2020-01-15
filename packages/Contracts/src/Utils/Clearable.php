<?php

namespace Aedart\Contracts\Utils;

/**
 * Clearable
 *
 * <br />
 *
 * Component is able to clear it's data, e.g. it's internal collection,
 * list, set, map,... etc.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Utils
 */
interface Clearable
{
    /**
     * Clears this component's data, collection, list, set...etc.
     *
     * @return void
     */
    public function clear() : void ;
}
