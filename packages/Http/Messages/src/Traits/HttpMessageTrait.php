<?php

namespace Aedart\Http\Messages\Traits;

use Psr\Http\Message\MessageInterface;

/**
 * Http Message Trait
 *
 * @see \Aedart\Contracts\Http\Messages\HttpMessageAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Messages\Traits
 */
trait HttpMessageTrait
{
    /**
     * Http Message instance
     *
     * @var MessageInterface|null
     */
    protected MessageInterface|null $httpMessage = null;

    /**
     * Set http message
     *
     * @param  MessageInterface|null  $message  Http Message instance
     *
     * @return self
     */
    public function setHttpMessage(MessageInterface|null $message): static
    {
        $this->httpMessage = $message;

        return $this;
    }

    /**
     * Get http message
     *
     * If no http message has been set, this method will
     * set and return a default http message, if any such
     * value is available
     *
     * @return MessageInterface|null http message or null if none http message has been set
     */
    public function getHttpMessage(): MessageInterface|null
    {
        if (!$this->hasHttpMessage()) {
            $this->setHttpMessage($this->getDefaultHttpMessage());
        }
        return $this->httpMessage;
    }

    /**
     * Check if http message has been set
     *
     * @return bool True if http message has been set, false if not
     */
    public function hasHttpMessage(): bool
    {
        return isset($this->httpMessage);
    }

    /**
     * Get a default http message value, if any is available
     *
     * @return MessageInterface|null A default http message value or Null if no default value is available
     */
    public function getDefaultHttpMessage(): MessageInterface|null
    {
        return null;
    }
}
