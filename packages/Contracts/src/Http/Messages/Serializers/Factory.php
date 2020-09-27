<?php

namespace Aedart\Contracts\Http\Messages\Serializers;

use Aedart\Contracts\Http\Messages\Exceptions\SerializationException;
use Aedart\Contracts\Http\Messages\Serializer;
use Psr\Http\Message\MessageInterface;

/**
 * Http Message Serializer Factory
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Http\Messages\Serializers
 */
interface Factory
{
    /**
     * Creates a Http Message Serializer for the given message
     *
     * @param  MessageInterface  $message
     *
     * @return Serializer Request or Response Serializer
     *
     * @throws SerializationException
     */
    public function make(MessageInterface $message): Serializer;
}
