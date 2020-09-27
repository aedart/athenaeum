<?php

namespace Aedart\Contracts\Http\Messages\Serializers;

use Aedart\Contracts\Http\Messages\HttpRequestAware;
use Aedart\Contracts\Http\Messages\Serializer;

/**
 * Request Serializer
 *
 * @see \Aedart\Contracts\Http\Messages\Serializer
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Http\Messages\Serializers
 */
interface RequestSerializer extends Serializer,
    HttpRequestAware
{

}
