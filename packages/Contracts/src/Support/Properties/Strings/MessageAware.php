<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Message Aware
 *
 * Component is aware of string "message"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface MessageAware
{
    /**
     * Set message
     *
     * @param string|null $message A message
     *
     * @return self
     */
    public function setMessage(string|null $message): static;

    /**
     * Get message
     *
     * If no message value set, method
     * sets and returns a default message.
     *
     * @see getDefaultMessage()
     *
     * @return string|null message or null if no message has been set
     */
    public function getMessage(): string|null;

    /**
     * Check if message has been set
     *
     * @return bool True if message has been set, false if not
     */
    public function hasMessage(): bool;

    /**
     * Get a default message value, if any is available
     *
     * @return string|null Default message value or null if no default value is available
     */
    public function getDefaultMessage(): string|null;
}
