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
     * The default data format to use for requests
     *
     * @var string
     */
    protected string $defaultDataFormat = RequestOptions::JSON;
}
