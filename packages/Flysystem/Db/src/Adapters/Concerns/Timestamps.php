<?php

namespace Aedart\Flysystem\Db\Adapters\Concerns;

use League\Flysystem\Config;

/**
 * Concerns Timestamps
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Flysystem\Db\Adapters\Concerns
 */
trait Timestamps
{
    /**
     * Resolves timestamp, when writing to table record
     *
     * If "timestamp" is set in given configuration, then it will be returned.
     * Otherwise, current unix timestamp is returned.
     *
     * @param Config $config
     *
     * @return int
     */
    protected function resolveLastModifiedTimestamp(Config $config): int
    {
        return $config->get('timestamp', time());
    }
}
