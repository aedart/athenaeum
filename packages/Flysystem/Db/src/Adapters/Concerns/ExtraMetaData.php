<?php

namespace Aedart\Flysystem\Db\Adapters\Concerns;

use Aedart\Utils\Json;
use JsonException;
use League\Flysystem\Config;

/**
 * Concerns Extra Meta-Data
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Flysystem\Db\Adapters\Concerns
 */
trait ExtraMetaData
{
    /**
     * Resolves extra meta data from configuration
     *
     * @param Config $config
     *
     * @return string|null Json encoded string or null if no extra meta data
     *
     * @throws JsonException
     */
    protected function resolveExtraMetaData(Config $config): string|null
    {
        $extra = $config->get('extra_metadata', null);
        if (!isset($extra)) {
            return null;
        }

        return Json::encode($extra);
    }

    /**
     * Decode extra meta data from database table
     *
     * @param string|null $data
     *
     * @return array|null
     *
     * @throws JsonException
     */
    protected function decodeExtraMetaData(string|null $data): array|null
    {
        if (!isset($data)) {
            return null;
        }

        return Json::decode($data, true);
    }
}
