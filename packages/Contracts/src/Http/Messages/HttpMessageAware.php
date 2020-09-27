<?php

namespace Aedart\Contracts\Http\Messages;

use Psr\Http\Message\MessageInterface;

/**
 * Http Message Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Http\Messages
 */
interface HttpMessageAware
{
    /**
     * Set http message
     *
     * @param  MessageInterface|null  $message  Http Message instance
     *
     * @return self
     */
    public function setHttpMessage(?MessageInterface $message);

    /**
     * Get http message
     *
     * If no http message has been set, this method will
     * set and return a default http message, if any such
     * value is available
     *
     * @return MessageInterface|null http message or null if none http message has been set
     */
    public function getHttpMessage(): ?MessageInterface;

    /**
     * Check if http message has been set
     *
     * @return bool True if http message has been set, false if not
     */
    public function hasHttpMessage(): bool;

    /**
     * Get a default http message value, if any is available
     *
     * @return MessageInterface|null A default http message value or Null if no default value is available
     */
    public function getDefaultHttpMessage(): ?MessageInterface;
}
