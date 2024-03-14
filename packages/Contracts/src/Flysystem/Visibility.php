<?php

namespace Aedart\Contracts\Flysystem;

use League\Flysystem\Visibility as FlysystemVisibility;

/**
 * Visibility
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Flysystem
 */
enum Visibility: string
{
    /**
     * Public visibility
     */
    case PUBLIC = FlysystemVisibility::PUBLIC;

    /**
     * Private visibility
     */
    case PRIVATE = FlysystemVisibility::PRIVATE;

    /**
     * Allowed visibility types
     */
    public static function allowed(): array
    {
        return [self::PUBLIC , self::PRIVATE ];
    }
}