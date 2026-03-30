<?php

namespace Aedart\Contracts\Utils\Enums;

/**
 * Has Default
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Utils\Enums
 */
interface HasDefault
{
    /**
     * Returns the default case of this enum
     *
     * @return self
     */
    public static function default(): self;
}
