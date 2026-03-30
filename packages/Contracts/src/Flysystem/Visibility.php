<?php

namespace Aedart\Contracts\Flysystem;

use Aedart\Contracts\Utils\Enums\Concerns;
use JsonSerializable;
use League\Flysystem\Visibility as FlysystemVisibility;

/**
 * Visibility
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Flysystem
 */
enum Visibility: string implements JsonSerializable
{
    use Concerns\BackedEnums;

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
     *
     * @return string[]
     */
    public static function allowed(): array
    {
        return self::values();
    }
}
