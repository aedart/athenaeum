<?php

namespace Aedart\Http\Clients\Drivers;

use GuzzleHttp\RequestOptions;

/**
 * Json Http Client
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Drivers
 */
class JsonHttpClient extends DefaultHttpClient
{
    /**
     * @inheritDoc
     */
    public function initialOptions(): array
    {
        return array_merge(parent::initialOptions(), [
            'data_format' => RequestOptions::JSON,
        ]);
    }
}
