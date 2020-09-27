<?php

namespace Aedart\Http\Messages\Serializers;

use Aedart\Contracts\Http\Messages\Serializer;
use Aedart\Http\Messages\Traits\HttpMessageTrait;
use Psr\Http\Message\MessageInterface;

/**
 * Base Serializer
 *
 * Http Message abstraction.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Messages\Serializers
 */
abstract class BaseSerializer implements Serializer
{
    use HttpMessageTrait;

    /**
     * BaseSerializer constructor.
     *
     * @param  MessageInterface|null  $message  [optional]
     */
    public function __construct(?MessageInterface $message = null)
    {
        $this->setHttpMessage($message);
    }

    /*****************************************************************
     * Internals
     ****************************************************************/
    
}
