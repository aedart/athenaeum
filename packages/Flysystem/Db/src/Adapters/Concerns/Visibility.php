<?php

namespace Aedart\Flysystem\Db\Adapters\Concerns;

use Aedart\Contracts\Flysystem\Visibility as VisibilityEnum;
use League\Flysystem\Config;

/**
 * Concerns Visibility
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Flysystem\Db\Adapters\Concerns
 */
trait Visibility
{
    /**
     * Resolves directory visibility, when writing to table record
     *
     * @param Config $config
     *
     * @return string
     */
    protected function resolveDirectoryVisibility(Config $config): string
    {
        return $config->get(
            Config::OPTION_VISIBILITY,
            $config->get(Config::OPTION_DIRECTORY_VISIBILITY, VisibilityEnum::PRIVATE->value)
        );
    }

    /**
     * Resolves file visibility, when writing to table record
     *
     * @param Config $config
     *
     * @return string
     */
    protected function resolveFileVisibility(Config $config): string
    {
        return $config->get(Config::OPTION_VISIBILITY, VisibilityEnum::PRIVATE->value);
    }
}
