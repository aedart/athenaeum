<?php

namespace Aedart\Contracts\Http\Messages;

use Aedart\Contracts\Http\Messages\Exceptions\SerializationException;
use Illuminate\Contracts\Support\Arrayable;

/**
 * Http Message Serializer
 *
 * Able to serialise a Http message.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Http\Messages
 */
interface Serializer extends Arrayable,
    HttpMessageAware
{
    /**
     * Returns string representation of the Http Message
     *
     * @return string
     *
     * @throws SerializationException
     */
    public function toString(): string;
}
