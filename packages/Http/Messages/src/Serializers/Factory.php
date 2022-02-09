<?php

namespace Aedart\Http\Messages\Serializers;

use Aedart\Contracts\Http\Messages\Serializer;
use Aedart\Contracts\Http\Messages\Serializers\Factory as SerializerFactoryInterface;
use Aedart\Http\Messages\Exceptions\HttpMessageSerializationException;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Http Message Serializer Factory
 *
 * @see \Aedart\Contracts\Http\Messages\Serializers\Factory
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Messages\Serializers
 */
class Factory implements SerializerFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function make(MessageInterface $message): Serializer
    {
        if ($message instanceof RequestInterface) {
            return new RequestSerializer($message);
        }

        if ($message instanceof ResponseInterface) {
            return new ResponseSerializer($message);
        }

        // Fail if unable to find fitting serializer
        throw new HttpMessageSerializationException(sprintf('Unable to make serializer for %s', $message::class));
    }
}
