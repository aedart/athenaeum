<?php

namespace Aedart\Contracts\Http\Messages\Serializers;

use Aedart\Contracts\Http\Messages\HttpResponseAware;
use Aedart\Contracts\Http\Messages\Serializer;

/**
 * Response Serializer
 *
 * @see \Aedart\Contracts\Http\Messages\Serializer
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Http\Messages\Serializers
 */
interface ResponseSerializer extends Serializer,
    HttpResponseAware
{

}
