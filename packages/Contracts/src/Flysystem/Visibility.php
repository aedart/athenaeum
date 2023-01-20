<?php

namespace Aedart\Contracts\Flysystem;

use League\Flysystem\Visibility as FlysystemVisibility;

/**
 * Visibility
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Flysystem
 */
interface Visibility
{
    /**
     * Public visibility
     */
    public const PUBLIC = FlysystemVisibility::PUBLIC;

    /**
     * Private visibility
     */
    public const PRIVATE = FlysystemVisibility::PRIVATE;

    /**
     * Allowed visibility types
     */
    public const ALLOWED = [
        self::PUBLIC,
        self::PRIVATE
    ];
}
