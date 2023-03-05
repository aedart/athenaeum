<?php

namespace Aedart\Contracts\Flysystem;

use League\Flysystem\Visibility as FlysystemVisibility;

/**
 * Visibility
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Flysystem
 */
enum Visibility
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
    case ALLOWED = [
    self::PUBLIC,
    self::PRIVATE
    ];
}
